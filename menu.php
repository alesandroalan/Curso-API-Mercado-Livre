    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="https://www.youtube.com/channel/UCfkk9UGL2DLtdunYuQiK4TQ" target="_blank">
        Curso API ML
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav" style="width: 100%;">
            <li class="nav-item">
                <a class="nav-link" href="home.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="user.php">Informações de usuário</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Anúncios
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="add-product.php">Adicionar</a>
                    <a class="dropdown-item" href="list-products.php">Listar</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Perguntas
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="list-questions.php">Listar</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="category-suggestion.php" role="button">
                    Sugestão de categorias
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Vendas
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="list-recent-orders.php" title="Vendas que ainda não expiraram (expiration_date)">Vendas Recentes</a>
                    <a class="dropdown-item" href="list-archived-orders.php" title="Vendas que já expiraram (expiration_date) ou que foram qualificadas por ambas as partes">Vendas Arquivadas</a>
                </div>
            </li>

        </ul>
        <ul class="navbar-nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link active" href="logout.php">Sair</a>
            </li>
        </ul>
    </div>
</nav>
