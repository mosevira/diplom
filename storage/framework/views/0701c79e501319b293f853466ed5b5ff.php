<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Список магазинов</h1>

        <?php if($branches->count() > 0): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Адрес</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($branch->name); ?></td>
                    <td><?php echo e($branch->address); ?></td>
                    <td><a href="<?php echo e(route('storekeeper.branches.products', $branch->id)); ?>" class="btn btn-primary btn-sm">Просмотреть товары</a></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>Нет магазинов.</p>
        <?php endif; ?>

        <a href="<?php echo e(route('storekeeper.dashboard')); ?>" class="btn btn-secondary">Назад на главную</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/storekeeperlayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\domains\diplom\resources\views/storekeeper/branches/index.blade.php ENDPATH**/ ?>