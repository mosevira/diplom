<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        <h1 class="mt-4 mb-4">Редактировать пользователя</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Имя:</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group">
                <label for="surname">Фамилия:</label>
                <input type="text" class="form-control" name="surname" id="surname" value="{{ old('surname', $user->surname) }}" required>
            </div>
            <div class="form-group">
                <label for="patronymic">Отчество:</label>
                <input type="text" class="form-control" name="patronymic" id="patronymic" value="{{ old('patronymic', $user->patronymic) }}">
            </div>
            <div class="form-group">
                <label for="birth_date">Дата рождения:</label>
                <input type="date" class="form-control" name="birth_date" id="birth_date" value="{{ old('birth_date', $user->birth_date) }}">
            </div>
            <div class="form-group">
                <label for="phone">Телефон:</label>
                <input type="tel" class="form-control" name="phone" id="phone" value="{{ old('phone', $user->phone) }}">
            </div>
            <div class="form-group">
                <label for="start_job_date">Дата начала работы:</label>
                <input type="date" class="form-control" name="start_job_date" id="start_job_date" value="{{ old('start_job_date', $user->start_job_date) }}">
            </div>
            <div class="form-group">
                <label for="end_job_date">Дата окончания работы:</label>
                <input type="date" class="form-control" name="end_job_date" id="end_job_date" value="{{ old('end_job_date', $user->end_job_date) }}">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="form-group">
                <label for="role">Роль:</label>
                <select class="form-control" name="role" id="role" required>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Администратор</option>
                    <option value="storekeeper" {{ old('role', $user->role) == 'storekeeper' ? 'selected' : '' }}>Кладовщик</option>
                    <option value="seller" {{ old('role', $user->role) == 'seller' ? 'selected' : '' }}>Продавец</option>
                </select>
            </div>
            <div class="form-group">
                <label for="branch_id">Филиал:</label>
                <select class="form-control" name="branch_id" id="branch_id">
                    <option value="">Выберите филиал</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('branch_id', $user->branch_id) == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Активен</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>

        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Назад к списку пользователей</a>
    </div>
            </main>
</body>
</html>
