@foreach($items as $item)
    <li class="{{ trim(($item->hasChildren() ? 'dropdown' : '').' '.($item->isActive() ? 'active' : '')) }}">
        <a{!! $item->getAttributes($item->hasChildren() ? [
            'class' => trim($item->getAttribute('class', '').' dropdown-toggle'),
             'data-toggle' => 'dropdown',
             'aria-expanded' => 'false'
        ] : []) !!}>
            {{ $item->getLabel() }}

            @if($item->hasChildren())
                <span class="fa fa-angle-down"></span>
            @endif
        </a>
        @if($item->hasChildren())
            @include('menu::dropdown', [
                'items' => $item->getChildren()
            ])
        @endif
    </li>
@endforeach