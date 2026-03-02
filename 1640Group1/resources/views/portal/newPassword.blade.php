<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4" style="margin-top:30px">
                <form action="{{ route('login') }}" method="">
                    <h>Create new password</h>
                    <div class="form-group">
                        <label for="password">New password</label>
                        <input type="password" class="form-control" placeholder="Enter new password" name="newPassword">
                    </div>
                    <div class="form-group">
                        <label for="password">Verify Password</label>
                        <input type="password" class="form-control" placeholder="Re-enter new password" name="verifyPassword">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-block btn-primary" type="submit">Change</button>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
