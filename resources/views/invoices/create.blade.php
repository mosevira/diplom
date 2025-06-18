@extends('layouts/storekeeperlayout')

@section('content')
    <h1>Создать накладную</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('invoices.store') }}" method="POST">
        @csrf

        @if(Auth::user()->role === 'admin')
            <div class="form-group">
                <label for="branch_id">Филиал:</label>
                <select class="form-control" name="branch_id" id="branch_id" required>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
        @else
            <div class="form-group">
                <label for="branch_id">Филиал:</label>
                <input type="text" class="form-control" value="{{ Auth::user()->branch->name }}" readonly>
                <input type="hidden" name="branch_id" value="{{ Auth::user()->branch_id }}">
            </div>
        @endif

        <div class="form-group">
            <label for="date">Дата:</label>
            <input type="date" class="form-control" name="date" id="date" required>
        </div>

        <div class="form-group">
            <label>Товары:</label>
            <table class="table">
                <thead>
                <tr>
                    <th>Товар</th>
                    <th>Цена</th>
                    <th>Количество</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>
                            <input type="number" class="form-control" name="product_quantities[{{ $product->id }}]" value="0" min="0">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Отмена</a>
    </form>
</div>
@endsection
