<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?=APPNAME?></title>
        <meta name="description" content="Stay organized and boost productivity with our simple and intuitive To-Do List App. Easily create, manage, and prioritize tasks to keep your day on track.">
        <link href="<?=ASSETS?>css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="<?=ASSETS?>css/styles.css">
    </head>
    <body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container">
                <a class="navbar-brand" href="<?=ROOT?>"><?=APPNAME?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <?php if(!empty($_SESSION['loggedInUserId'])): ?>
                        <li class="nav-item">
                            <form action="<?=ROOT?>auth/logout" method="POST">
                                <button class="btn border-0 text-decoration-underline" onclick="return confirm('Are you sure you want to logout?')">Logout</button>
                            </form>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>