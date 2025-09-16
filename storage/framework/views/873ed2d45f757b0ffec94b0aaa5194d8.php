

<?php $__env->startSection('content'); ?>

    </body>
    <div class="container">
        <h2>ورود با Secret Key</h2>

        <?php if(isset($error)): ?>
            <div class="message">
                <p><?php echo e($error); ?></p>
            </div>
        <?php endif; ?>


        <form action="<?php echo e(route('login')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <input type="text" name="secret_key" placeholder="Secret Key خود را وارد کنید" required>

            <button type="submit">ورود</button>
        </form>
    </div>

    

<?php $__env->stopSection(); ?>
<?php echo $__env->make("Layouts.layout", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\software\Installed\laragon\www\endpoint\resources\views/login.blade.php ENDPATH**/ ?>