// validacaoFormulario.js

// Função para validar CPF (exemplo simples, pode ser adaptado para uma validação completa)
function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, ''); // Remove qualquer caractere que não seja número
    return cpf.length === 11;
}

// Função para validar o formulário
function validarFormulario() {
    const nome = document.getElementById("nome_funcionario").value;
    const cpf = document.getElementById("cpf_funcionario").value;
    const email = document.getElementById("email").value;
    const contato = document.getElementById("contato_funcionario").value;

    let errorMessage = "";

    // Verifica se o nome está preenchido
    if (!nome) {
        errorMessage += "O campo Nome é obrigatório.\n";
    }

    // Valida o CPF
    if (!validarCPF(cpf)) {
        errorMessage += "CPF inválido. Deve conter 11 dígitos.\n";
    }

    // Verifica se o email está no formato correto
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        errorMessage += "Formato de email inválido.\n";
    }

    // Verifica se o campo de contato está preenchido
    if (!contato) {
        errorMessage += "O campo Contato é obrigatório.\n";
    }

    // Exibe os erros, se houver
    if (errorMessage) {
        alert(errorMessage);  // Mostra os erros em um alert
        return false;  // Impede o envio do formulário
    }

    return true;  // Permite o envio do formulário se não houver erros
}
