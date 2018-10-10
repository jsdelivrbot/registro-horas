<!-- Breadcrumb -->
<ol class="breadcrumb">
    <?php
    $currentAction = \Route::currentRouteAction();
    list($controller, $method) = explode('@', $currentAction);
    ?>
    <?php
    if (isset($breadcrumb)) {
        if (count($breadcrumb) > 0) {
            ?>
            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
            <?php
            foreach ($breadcrumb as $key => $value) {
                ?>
                <li class="breadcrumb-item"> 
                    <?php if ($value['url'] != "") { ?>
                        <a href="{{url($value['url'])}}">{{$value['label']}}</a>
                    <?php } else { ?>
                        {{$value['label']}}
                <?php } ?>
                </li>
                <?php
            }
        } else {
            ?>
            <li class="breadcrumb-item">Dashboard</li>
                <?php
            }
        }
        ?>
</ol>
