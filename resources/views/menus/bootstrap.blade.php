@if(!isset($innerLoop))
<ul class="footer-explore-list list-unstyled">
@else
<ul class="footer-explore-list list-unstyled">
@endif

@php

    if (Voyager::translatable($items)) {
        $items = $items->load('translations');
    }

@endphp

@foreach ($items as $item)

    @php

        $originalItem = $item;
        if (Voyager::translatable($item)) {
            $item = $item->translate($options->locale);
        }

        $listItemClass = null;
        $linkAttributes =  null;
        $styles = null;
        $icon = null;
        $caret = null;

        // Background Color or Color
        if (isset($options->color) && $options->color == true) {
            $styles = 'color:'.$item->color;
        }
        if (isset($options->background) && $options->background == true) {
            $styles = 'background-color:'.$item->color;
        }

        // With Children Attributes
        if(!$originalItem->children->isEmpty()) {
            $linkAttributes ='dropdown-indicator';
            $caret = '<i class="fas fa-chevron-down"></i>';

            if(url($item->link()) == url()->current()){
                $listItemClass = '';
            }else{
                $listItemClass = '';
            }
        }

        // Set Icon
        if(isset($options->icon) && $options->icon == true){
            $icon = '<i class="' . $item->icon_class . '"></i>';
        }

    @endphp

    <li class="{{ $listItemClass }}">
        <a href="{{ url($item->link()) }}" class=""  style="">
            {!! $icon !!}
            {{ $item->title }}
            {!! $caret !!}
        </a>
        @if(!$originalItem->children->isEmpty())
        @include('menus.bootstrap', ['items' => $originalItem->children, 'options' => $options, 'innerLoop' => true])
        @endif
    </li>
@endforeach

</ul>
