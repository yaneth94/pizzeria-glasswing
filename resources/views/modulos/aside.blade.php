<div class="app-sidebar__user"><img class="app-sidebar__user-avatar"
    src="https://uybor.uz/borless/uybor/img/user-images/user_no_photo_300x300.png" alt="User Image" width="50" >
<div>
    <p class="app-sidebar__user-name">{{ Auth::user()->username }}</p>
    <p class="app-sidebar__user-designation">{{ Auth::user()->name }}</p>
</div>
</div>
<ul class="app-menu">
<li><a class="app-menu__item {{isActive('home')}} " href="{{route('home')}}"><i class="app-menu__icon fa fa-home fa-lg"></i><span class="app-menu__label">Home</span></a></li>
<li><a class="app-menu__item " href="">
<i class="app-menu__icon fa fa-plus-square"></i>
<span class="app-menu__label">Pizzas</span></a></li>
<li><a class="app-menu__item " href="">
    <i class="app-menu__icon fa fa-users"></i>
    <span class="app-menu__label">Ingredientes</span></a></li>
</ul>
