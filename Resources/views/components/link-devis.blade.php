<a href="{{ $link ?? ''}}" {{$attributes->merge(['class' => "ignore-link"])}} target="_blank">
   @if($slot)
        {{$slot}}
   @else
        Voir le devis
   @endif
</a>
