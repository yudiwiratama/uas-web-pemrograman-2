<!DOCTYPE html>
<html>
<head>
    <title>Debug Material Create</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; }
        .error { color: red; }
        .info { background: #f0f0f0; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>
    <h2>🔍 Debug Material Create Route</h2>

    <div class="info">
        <h3>1. Authentication Status</h3>
        <?php if(auth()->guard()->check()): ?>
            <span class="success">✅ User logged in: <?php echo e(auth()->user()->name); ?> (<?php echo e(auth()->user()->email); ?>)</span><br>
            <span class="success">Role: <?php echo e(auth()->user()->role); ?></span><br>
        <?php else: ?>
            <span class="error">❌ User NOT logged in</span><br>
            <a href="<?php echo e(route('login')); ?>">👉 Login here</a><br>
        <?php endif; ?>
    </div>

    <div class="info">
        <h3>2. Available Courses</h3>
        <?php
            $courses = App\Models\Course::approved()->get();
        ?>
        <?php if($courses->count() > 0): ?>
            <span class="success">✅ <?php echo e($courses->count()); ?> approved courses available:</span><br>
            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($course->judul); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <span class="error">❌ No approved courses available</span><br>
        <?php endif; ?>
    </div>

    <div class="info">
        <h3>3. Test Links</h3>
        <a href="<?php echo e(route('login')); ?>">🔑 Login Page</a><br>
        <a href="<?php echo e(route('materials.index')); ?>">📚 Materials Index</a><br>
        <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('materials.create')); ?>">➕ Create Material (authenticated)</a><br>
            <?php if(auth()->user()->isAdmin()): ?>
                <a href="<?php echo e(route('approvals.index')); ?>">👨‍💼 Admin Panel</a><br>
            <?php endif; ?>
        <?php else: ?>
            <span class="error">Login required to create materials</span><br>
        <?php endif; ?>
    </div>

    <div class="info">
        <h3>4. Route Information</h3>
        Current Route: <?php echo e(Route::currentRouteName()); ?><br>
        Current URL: <?php echo e(request()->fullUrl()); ?><br>
        User Agent: <?php echo e(request()->userAgent()); ?><br>
    </div>

    <div class="info">
        <h3>5. Quick Actions</h3>
        <?php if(auth()->guard()->check()): ?>
            <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
                <?php echo csrf_field(); ?>
                <button type="submit">Logout</button>
            </form>
        <?php else: ?>
            <form method="GET" action="<?php echo e(route('login')); ?>" style="display: inline;">
                <button type="submit">Go to Login</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html> <?php /**PATH /home/wiratama/semester-4/pemrograman-web-2/learning-dev/resources/views/debug.blade.php ENDPATH**/ ?>