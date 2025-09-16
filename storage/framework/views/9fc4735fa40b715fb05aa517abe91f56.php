

<?php $__env->startSection('content'); ?>
    
    <div style="display: flex; flex-wrap: wrap; max-width: 1200px; margin: 20px auto; gap: 20px; align-items:
                        flex-start; padding: 10px; box-sizing: border-box;">
        <!-- کارت خوشامدگویی -->
        <center>
            <div
                style="flex: 1 1 100%; background:#fff; border-radius:10px; padding:15px; box-shadow:0 0 10px rgba(0,0,0,0.1);">
                <h4>سلام، <?php echo e($data->fname); ?> 👋</h4>


                <!-- فیلتر پیام ها -->
                <div style="background: #fff; border-radius: 10px; padding: 20px; box-shadow:0 0 10px rgba(0,0,0,0.1);">
                    <h3 style="margin-bottom: 15px;">فیلتر پیام ها</h3>
                    <form action="<?php echo e(route('dashboard')); ?>" method="get">
                        <?php echo csrf_field(); ?>
                        <p>از تاریخ</p>
                        <input type="datext" data-jdp name="startDate" placeholder="از تاریخ" data-jdp-only-date required>
                        <p>تا تاریخ</p>
                        <input type="datext" data-jdp name="endDate" placeholder="تا تاریخ" data-jdp-only-date required>
                        <input type="hidden" name="id" value="<?php echo e($data->id); ?>">
                        <button type="submit">ارسال</button>
                    </form>
                </div>
            </div><br>
        </center>
    </div>


    <!-- بخش پیام‌ها -->
    <div style="flex: 3 1 500px; background:#fff; border-radius: 10px; padding: 20px; box-shadow:0 0 10px rgba(0,0,0,0.1);">
        <h3 style="margin-bottom: 15px;">پیام‌های ارسال شده</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px;">

            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div
                    style="background: #c2c2c2ff; border-radius: 8px; padding: 15px; text-align: right; box-shadow: 0 0 5px rgba(0,0,0,0.05);">
                    <a href="<?php echo e(route('admin.userdashboard', $item->id)); ?>" class="my-link">
                        <strong>نام: <?php echo e($item->fname); ?></strong><br><br>
                        <strong>نام خانوادگی: <?php echo e($item->lname); ?></strong>
                    </a>
                    <small style="color: gray;"><?php echo e($item->created_at); ?></small>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p style="color: gray;">هنوز پیامی ثبت نشده</p>
            <?php endif; ?>

            
        </div>

    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\software\Installed\laragon\www\endpoint\resources\views/admin.blade.php ENDPATH**/ ?>