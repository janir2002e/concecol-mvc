<aside class="dashboard__sidebar">
    <nav class="dashboard__menu"> 
        <a href="/admin/dashboard" class="dashboard__enlace <?php echo pagina_actual('/dashboard') ? 'dashboard__enlace--actual' : ''; ?>"> 
            <i class="fa-solid fa-house dashboard__icono"></i>
            <span class="dashboard__menu--texto">
                Inicio
            </span>
        </a>

        <a href="/admin/automoviles" class="dashboard__enlace <?php echo pagina_actual('/automoviles') ? 'dashboard__enlace--actual' : ''; ?>"> 
            <i class="fa-solid fa-car dashboard__icono"></i>
            <span class="dashboard__menu--texto">
                Automovíles
            </span>
        </a>

        <a href="/admin/vendedores" class="dashboard__enlace <?php echo pagina_actual('/vendedores') ? 'dashboard__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-suitcase dashboard__icono"></i>
            <span class="dashboard__menu--texto">
                Vendedores
            </span>
        </a>

        <a href="/admin/usuarios" class="dashboard__enlace <?php echo pagina_actual('/usuarios') ? 'dashboard__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-person dashboard__icono"></i>
            <span class="dashboard__menu--texto">
                Usuarios
            </span>
        </a>
    </nav>

</aside>