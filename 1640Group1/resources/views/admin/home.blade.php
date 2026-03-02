<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <div class="d-flex">
        <aside id="sidebar">
            <div class="sidebar-logo">
                <a href="#">Home</a>
            </div>
            <ul class="sidebar-nav p-0">
                <li class="sidebar-header">
                    Accounts
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('admin-userManagement') }}" class="sidebar-link">Manage user account</a>
                    <a href="{{ route('admin-newUser') }}" class="sidebar-link">Create new user account</a>
                </li>
            </ul>

        </aside>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>

