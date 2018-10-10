<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <?php if (session('success')){ ?>
            <div class="alertmsg alert alert-success">
                {{ session('success') }}
            </div>
            <?php } ?>
            <?php if(session('error')){ ?>
            <div class="alertmsg alert alert-danger" style="display:block;">
                <?php echo session('error'); ?>
            </div>
            <?php } ?>
            @yield('content')
        </div>
    </div>
</div>
