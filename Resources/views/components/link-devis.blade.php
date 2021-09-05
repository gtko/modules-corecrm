<a href="{{ $link ?? ''}}" {{$attributes->merge(['class' => "ignore-link"])}}>
   @if($slot)
        {{$slot}}
   @else
        Voir le devis
   @endif
</a>
