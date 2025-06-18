<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление пользователями</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap JS and dependencies (optional, but needed for some components like modals) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
     <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #007bff;
            color: white;
        }

        .navbar-brand {
            color: white !important;
        }

        .nav-link {
            color: white !important;
        }

        .nav-link:hover {
            color: #ddd !important;
        }

        .container-fluid {
            padding-top: 20px;
        }

        .list-group-item {
            border: none;
            border-radius: 0;
            padding: 0.75rem 0;
        }

        .list-group-item:hover {
            background-color: #e9ecef;
        }

        .card {
            border: none;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        /* Исправление цвета текста в боковой панели */
        #sidebar .nav-link {
            color: #333 !important;
        }

        #sidebar .nav-link:hover {
            color: #007bff !important;
        }

        #sidebar .nav-link.active {
            color: #fff !important;
            background-color: #007bff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Панель администратора</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">
                            <i class="fas fa-sign-out-alt"></i> Выход
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">
                                <i class="fas fa-home"></i> Главная
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('admin.users.index') }}">
                                <i class="fas fa-plus-circle"></i> Управление пользователями
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('branches.index') }}">
                                <i class="fas fa-plus-circle"></i>Управление филиалами
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('storekeeper.branches.index') }}">
                                <i class="fas fa-store"></i> Анализ и итоги
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container mt-5">
        <h1 class="mt-4 mb-4">Управление пользователями</h1>

        <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Создать пользователя</a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Email</th>
                    <th>Роль</th>
                    <th>Филиал</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->surname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role == 'admin')
                            Администратор
                        @elseif($user->role == 'storekeeper')
                            Кладовщик
                        @elseif($user->role == 'seller')
                            Продавец
                        @else
                            Неизвестно
                        @endif
                    </td>
                    <td>
                        @if($user->branch)
                            {{ $user->branch->name }}
                        @else
                            Нет филиала
                        @endif
                    </td>
                    <td>
                        @if($user->is_active)
                            <span class="badge badge-success">Активен</span>
                        @else
                            <span class="badge badge-danger">Неактивен</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">Редактировать</a>
                        <form action="{{ route('admin.users.toggleActive', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-warning' : 'btn-success' }}">{{ $user->is_active ? 'Деактивировать' : 'Активировать' }}</button>
                        </form>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены, что хотите удалить этого пользователя?')">Удалить</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Назад на главную</a>
    </div>
</body>
</html>
