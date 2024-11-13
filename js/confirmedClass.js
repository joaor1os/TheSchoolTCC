function confirmarCriacaoAula(salaId) {
    var resposta = confirm("Tem certeza de que deseja criar a aula para esta sala?");
    if (resposta) {
        // Se o usuário clicar em "Sim", redireciona para a página de criação de aula
        window.location.href = "criar_aula.php?sala_id=" + salaId;
    }
}