<?php
include_once 'db.php';
include_once '../includes/class/Professor.php';
include_once 'EmailSender.php';

class funcionario_instituicao {
    private $conn;
    private $table_name = "funcionario_instituicao";

    private $nome_funcionario;
    private $cpf_funcionario;
    private $data_nascimento_funcionario;
    private $sexo_funcionario;
    private $situacao_funcionario;
    private $contato_funcionario;
    private $tipo_funcionario;
    private $email;
    private $senha;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Setters
    public function setNomeFuncionario($nome_funcionario) {
        $this->nome_funcionario = $nome_funcionario;
    }

    public function setCpfFuncionario($cpf_funcionario) {
        $this->cpf_funcionario = $cpf_funcionario;
    }

    public function setDataNascimentoFuncionario($data_nascimento_funcionario) {
        $this->data_nascimento_funcionario = $data_nascimento_funcionario;
    }

    public function setSexoFuncionario($sexo_funcionario) {
        $this->sexo_funcionario = $sexo_funcionario;
    }

    public function setSituacaoFuncionario($situacao_funcionario) {
        $this->situacao_funcionario = $situacao_funcionario;
    }

    public function setContatoFuncionario($contato_funcionario) {
        $this->contato_funcionario = $contato_funcionario;
    }

    public function setTipoFuncionario($tipo_funcionario){
        $this->tipo_funcionario = $tipo_funcionario;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }


    // Getters
    public function getNomeFuncionario() {
        return $this->nome_funcionario;
    }

    public function getCpfFuncionario() {
        return $this->cpf_funcionario;
    }

    public function getDataNascimentoFuncionario() {
        return $this->data_nascimento_funcionario;
    }

    public function getSexoFuncionario() {
        return $this->sexo_funcionario;
    }

    public function getSituacaoFuncionario() {
        return $this->situacao_funcionario;
    }

    public function getContatoFuncionario() {
        return $this->contato_funcionario;
    }

    public function getTipoFuncionario() {
        return $this->tipo_funcionario;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSenha() {
        return $this->senha;
    }

    private function cpfExists() {
        $query = "SELECT cpf_funcionario FROM " . $this->table_name . " WHERE cpf_funcionario = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $cpf = $this->getCpfFuncionario(); // Pega o valor do CPF
        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        $stmt->store_result();
        
        return $stmt->num_rows > 0;
    }

    public function buscarFuncionariosAtivos() {
        // Consulta SQL para buscar funcionários ativos
        $query = "SELECT * FROM " . $this->table_name . " WHERE situacao_funcionario = 1";  // 1 representa ativo
        
        // Preparar a consulta
        $stmt = $this->conn->prepare($query);
        
        // Executa a consulta
        $stmt->execute();
        
        // Obtém o resultado
        $result = $stmt->get_result();
        
        // Verifica se houve resultados
        if ($result->num_rows > 0) {
            // Retorna os resultados como array associativo
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            // Caso não encontre nenhum resultado
            return [];
        }
    }

    // Método para cadastrar o funcionario
    public function cadastrar() {
        // Verifica se o CPF já está cadastrado
        if ($this->cpfExists()) {
            $msg = "Erro: O CPF já está cadastrado.";
            echo "<script>
                alert('$msg');
                window.location.href = 'gerenciar_funcionario_instituicao.php';
              </script>";
            return false;
        }
    
        // Verifica se o email já está cadastrado
        if ($this->emailExists()) {
            $msg = "Erro: O e-mail já está cadastrado.";
            echo "<script>
                alert('$msg');
                window.location.href = 'gerenciar_funcionario_instituicao.php';
              </script>";
            return false;
        }
    
        // Prepara a inserção na tabela funcionario_instituicao
        $query = "INSERT INTO " . $this->table_name . " (cpf_funcionario, nome_funcionario, data_nascimento_funcionario, sexo_funcionario, situacao_funcionario, contato_funcionario, tipo_funcionario, email, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
    
        // Armazena os valores em variáveis
        $cpf_funcionario = $this->getCpfFuncionario();
        $nome_funcionario = $this->getNomeFuncionario();
        $data_nascimento_funcionario = $this->getDataNascimentoFuncionario();
        $sexo_funcionario = $this->getSexoFuncionario();
        $situacao_funcionario = $this->getSituacaoFuncionario();
        $contato_funcionario = $this->getContatoFuncionario();
        $tipo_funcionario = $this->getTipoFuncionario();
        $email = $this->getEmail();
        $senha_criptografada = password_hash($this->getSenha(), PASSWORD_DEFAULT);
    
        // Faz o bind dos parâmetros
        $stmt->bind_param("ssssisiss", 
            $cpf_funcionario, 
            $nome_funcionario,
            $data_nascimento_funcionario, 
            $sexo_funcionario, 
            $situacao_funcionario, 
            $contato_funcionario, 
            $tipo_funcionario, 
            $email, 
            $senha_criptografada
        );
    
        if ($stmt->execute()) {
            // Envia o e-mail de boas-vindas
            $this->sendEmail();
    
            // Verifica se o tipo é 2 (professor) e insere na tabela professor
            if ($this->tipo_funcionario == 2) {
                $id_funcionario = $this->conn->insert_id;
                $this->cadastrarProfessor($id_funcionario);
            }
    
            return true;
        } else {
            echo "Erro ao cadastrar o funcionário: " . $stmt->error;
            return false;
        }
    }
    
    

    // Verificação se o e-mail já existe no banco de dados
    private function emailExists() {
        $query = "SELECT email FROM " . $this->table_name . " WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $email = $this->getEmail(); // Pega o valor do email
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        return $stmt->num_rows > 0;
    }

    // Função para enviar o e-mail
    private function sendEmail() {
        $subject = 'Cadastro de colaborador - TheSchool';
        $body = 'Sua conta foi criada com sucesso. Sua senha é: ' . $this->getSenha();
        sendEmail($this->getEmail(), $subject, $body);
    }

    public function buscarPorId($id_funcionario) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_funcionario = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_funcionario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function buscarPorNomeOuCpf($busca) {
        // Consulta SQL para buscar pelo nome ou CPF
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE nome_funcionario LIKE ? 
                  OR cpf_funcionario = ?";

        // Preparar a consulta
        if ($stmt = $this->conn->prepare($query)) {
            // Adiciona os percentuais para a busca parcial com LIKE
            $busca_como = "%" . $busca . "%";

            // Bind dos parâmetros (nome com LIKE e CPF exato)
            $stmt->bind_param("ss", $busca_como, $busca);

            // Executa a consulta
            $stmt->execute();

            // Obtém o resultado
            $result = $stmt->get_result();

            // Verifica se houve resultados
            if ($result->num_rows > 0) {
                // Retorna os resultados como array associativo
                return $result->fetch_all(MYSQLI_ASSOC);
            } else {
                // Caso não encontre nenhum resultado
                return [];
            }
        } else {
            echo "Erro ao preparar a consulta: " . $this->conn->error;
            return false;
        }
    }
    

    public function atualizar($id_funcionario) {
        // Query de atualização, sem incluir tipo_funcionario e senha
        $query = "UPDATE " . $this->table_name . " 
                  SET nome_funcionario = ?, cpf_funcionario = ?, data_nascimento_funcionario = ?, 
                      sexo_funcionario = ?, situacao_funcionario = ?, contato_funcionario = ?, email = ? 
                  WHERE id_funcionario = ?";
                  
        $stmt = $this->conn->prepare($query);
        
        // Verificação de erros na preparação da query
        if (!$stmt) {
            die("Erro na preparação da query: " . $this->conn->error);
        }
    
        // Bind dos parâmetros
        $stmt->bind_param("ssssissi", 
            $this->nome_funcionario, 
            $this->cpf_funcionario,
            $this->data_nascimento_funcionario, 
            $this->sexo_funcionario, 
            $this->situacao_funcionario, 
            $this->contato_funcionario, 
            $this->email,
            $id_funcionario
        );
    
        // Execução e verificação de sucesso
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Erro ao atualizar: " . $stmt->error;
            return false;
        }
    }
    
    

    

    public function deletar($id_funcionario) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_funcionario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_funcionario);
        return $stmt->execute();
    }
    
    public function cadastrarProfessor($id_funcionario) {
        // Chama o método da classe Professor para inserir na tabela professor
        $professor = new Professor($id_funcionario, 'Formação padrão', 6); // Exemplo de dados padrão
        $professor->cadastrarProfessor();
    }

    public function generateAndSetPassword() {
        $this->setSenha($this->generatePassword());
    }

    private function generatePassword($length = 8) {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $length);
    }
}

?>
