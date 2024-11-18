<?php

include_once 'db.php';
include_once 'EmailSender.php';

class Aluno {
    private $conn;
    private $table_name = "aluno";

    private $matricula_aluno;
    private $cpf_aluno;
    private $nome_aluno;
    private $data_nascimento_aluno;
    private $sexo_aluno;
    private $situacao_aluno = 1; // Padrão ativo
    private $contato_aluno;
    private $email;
    private $senha;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Getters e Setters
    public function getMatriculaAluno() { return $this->matricula_aluno; }
    public function setMatriculaAluno($matricula_aluno) { $this->matricula_aluno = $matricula_aluno; }

    public function getCpfAluno() { return $this->cpf_aluno; }
    public function setCpfAluno($cpf_aluno) { $this->cpf_aluno = $cpf_aluno; }

    public function getNomeAluno() { return $this->nome_aluno; }
    public function setNomeAluno($nome_aluno) { $this->nome_aluno = $nome_aluno; }

    public function getDataNascimentoAluno() { return $this->data_nascimento_aluno; }
    public function setDataNascimentoAluno($data_nascimento_aluno) { $this->data_nascimento_aluno = $data_nascimento_aluno; }

    public function getSexoAluno() { return $this->sexo_aluno; }
    public function setSexoAluno($sexo_aluno) { $this->sexo_aluno = $sexo_aluno; }

    public function getSituacaoAluno() { return $this->situacao_aluno; }
    public function setSituacaoAluno($situacao_aluno) { $this->situacao_aluno = $situacao_aluno; }

    public function getContatoAluno() { return $this->contato_aluno; }
    public function setContatoAluno($contato_aluno) { $this->contato_aluno = $contato_aluno; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getSenha() { return $this->senha; }
    public function setSenha($senha) { $this->senha = $senha; }


    private function cpfExists() {
        $query = "SELECT cpf_aluno FROM " . $this->table_name . " WHERE cpf_aluno = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $cpf = $this->getCpfAluno();
        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        $stmt->store_result();
        
        return $stmt->num_rows > 0;
    }


    private function emailExists() {
        $query = "SELECT email FROM " . $this->table_name . " WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $email = $this->getEmail();
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        return $stmt->num_rows > 0;
    }

    // Cadastrar o aluno
    public function cadastrar() {
        if ($this->cpfExists()) {
            echo "Erro: O CPF já está cadastrado.";
            return false;
        }

        if ($this->emailExists()) {
            echo "Erro: O e-mail já está cadastrado.";
            return false;
        }

        $query = "INSERT INTO " . $this->table_name . " (cpf_aluno, nome_aluno, data_nascimento_aluno, sexo_aluno, situacao_aluno, contato_aluno, email, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        // Armazenar valores em variáveis
        $cpf_aluno = $this->getCpfAluno();
        $nome_aluno = $this->getNomeAluno();
        $data_nascimento_aluno = $this->getDataNascimentoAluno();
        $sexo_aluno = $this->getSexoAluno();
        $situacao_aluno = $this->getSituacaoAluno();
        $contato_aluno = $this->getContatoAluno();
        $email = $this->getEmail();
        $senha_criptografada = password_hash($this->getSenha(), PASSWORD_DEFAULT);

        $stmt->bind_param("ssssssss", 
            $cpf_aluno, 
            $nome_aluno, 
            $data_nascimento_aluno, 
            $sexo_aluno, 
            $situacao_aluno, 
            $contato_aluno,
            $email, 
            $senha_criptografada
        );

        if ($stmt->execute()) {
            $this->sendEmail();
            return true;
        } else {
            echo "Erro ao cadastrar o aluno.";
            return false;
        }
    }

    public function buscarPorNomeOuCpf($busca) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE nome_aluno LIKE ? OR cpf_aluno = ?";
        $stmt = $this->conn->prepare($query);
        
        $buscaParam = "%$busca%";
        $stmt->bind_param('ss', $buscaParam, $busca);
        
        $stmt->execute();
        $result = $stmt->get_result(); 
        return $result->fetch_all(MYSQLI_ASSOC); 
    }

    public function buscarPorNome($nome) {
        $query = "SELECT id_aluno, nome_aluno FROM aluno WHERE nome_aluno LIKE ?";
        $stmt = $this->conn->prepare($query);
        $nome = "%$nome%";
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $result = $stmt->get_result();

        $alunos = [];
        while ($row = $result->fetch_assoc()) {
            $alunos[] = $row;
        }

        return $alunos;
    }

    public function buscarPorId($id_aluno) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_aluno = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_aluno);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
    

    public function getNomeSituacao($id_situacao) {
        $query = "SELECT nome_situacao FROM situacao WHERE id_situacao = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_situacao);
        $stmt->execute();
        $result = $stmt->get_result();
        $situacao = $result->fetch_assoc();
        
        return $situacao['nome_situacao'] ?? null;
    }


    private function sendEmail() {
        $subject = 'Cadastro de Aluno';
        $body = 'Sua conta foi criada com sucesso. Sua senha é: ' . $this->getSenha();
        sendEmail($this->getEmail(), $subject, $body);
    }


    public function atualizar($id_aluno) {

        $emailAtual = $this->buscarEmailPorId($id_aluno);
        
        $query = "UPDATE " . $this->table_name . " SET nome_aluno = ?, cpf_aluno = ?, data_nascimento_aluno = ?, sexo_aluno = ?, situacao_aluno = ?, contato_aluno = ?, email = ? WHERE id_aluno = ?";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bind_param(
            'sssssssi',
            $this->nome_aluno,
            $this->cpf_aluno,
            $this->data_nascimento_aluno,
            $this->sexo_aluno,
            $this->situacao_aluno,
            $this->contato_aluno,
            $this->email,
            $id_aluno
        );
        
        if ($stmt->execute()) {
            if ($emailAtual !== $this->email) {

                $novaSenha = $this->gerarNovaSenha();
                $senhaCriptografada = password_hash($novaSenha, PASSWORD_DEFAULT);

                $querySenha = "UPDATE " . $this->table_name . " SET senha = ? WHERE id_aluno = ?";
                $stmtSenha = $this->conn->prepare($querySenha);
                $stmtSenha->bind_param("si", $senhaCriptografada, $id_aluno);
                $stmtSenha->execute();

                $this->sendEmailNovaSenha($novaSenha);
            }

            return true;
        } else {
            echo "Erro ao atualizar aluno.";
            return false;
        }
    }

    private function buscarEmailPorId($id_aluno) {
        $query = "SELECT email FROM " . $this->table_name . " WHERE id_aluno = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_aluno);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['email'];
        }
        
        return null;
    }

    private function gerarNovaSenha($tamanho = 4) {
        $caracteres = '0123456789';
        $novaSenha = '';
        for ($i = 0; $i < $tamanho; $i++) {
            $novaSenha .= $caracteres[random_int(0, strlen($caracteres) - 1)];
        }
        return $novaSenha;
    }

    // Função para enviar e-mail com nova senha
    private function sendEmailNovaSenha($senha) {
        $subject = 'Atualização de e-mail';
        $body = 'Seu e-mail foi atualizado com sucesso. Sua nova senha é: ' . $senha;
        sendEmail($this->getEmail(), $subject, $body);
    }



    // Geração da senha automática
    public function generateAndSetPassword() {
        $this->setSenha($this->generatePassword());
    }

    private function generatePassword($length = 4) {
        return substr(str_shuffle('0123456789'), 0, $length);
    }
}
?>
