async function fetchNews() {
    const apiKey = 'fe9d9e55f2214790b294183b16fd4411'; // Substitua pela sua chave de API do NewsAPI

    // Obtém a data de hoje no formato 'YYYY-MM-DD'
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    
    // Obtém a data de 7 dias atrás
    const pastDate = new Date();
    pastDate.setDate(today.getDate() ); // Subtrai 7 dias da data atual
    const formattedPastDate = pastDate.toISOString().split('T')[0]; // Formata a data

    const url = `https://newsapi.org/v2/everything?q=educação OR educação OR escolas&from=${formattedPastDate}&to=${formattedDate}&sortBy=popularity&language=pt&apiKey=${apiKey}`;
    
    try {
        const response = await fetch(url);
        const data = await response.json();
        console.log(data); // Verifique a resposta da API no console

        // Verifica se há artigos
        if (data.articles && data.articles.length > 0) {
            // Preenche os cards de notícia com os dados
            const newsSection = document.querySelector('.news-section .row');
            newsSection.innerHTML = ''; // Limpa a seção de notícias

            data.articles.slice(0, 3).forEach(article => {
                const card = `
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <img src="${article.urlToImage || 'https://via.placeholder.com/350x150'}" class="card-img-top" alt="Notícia">
                            <div class="card-body">
                                <h5 class="card-title">${article.title}</h5>
                                <p class="card-text">${article.description || 'Resumo não disponível.'}</p>
                                <a href="${article.url}" class="btn btn-primary" target="_blank">Leia Mais</a>
                            </div>
                        </div>
                    </div>
                `;
                newsSection.innerHTML += card;
            });
        } else {
            // Exibe mensagem caso não haja notícias
            const newsSection = document.querySelector('.news-section .row');
            newsSection.innerHTML = '<p class="text-center">Nenhuma notícia disponível no momento.</p>';
        }
    } catch (error) {
        console.error('Erro ao buscar notícias:', error);
    }
}

// Chama a função de notícias ao carregar a página
window.onload = fetchNews;
