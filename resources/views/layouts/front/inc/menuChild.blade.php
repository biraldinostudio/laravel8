<ul class="submenu dropdown-menu">
    @foreach($childs as $child)
        <li><a class="dropdown-item" href="">{{ $child->name }} @if(count($child->childs)) &raquo @endif</a>
            @if(count($child->childs))
                @include('layouts.front.inc.menuChild',['childs' => $child->childs])
            @endif
        </li>
    @endforeach 
</ul>