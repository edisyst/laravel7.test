{{-- $attributes VARIABILE GLOBALE: PRENDE GLI ATTRIBUTI DELLE CLASSI TIPO LO STYLE--}}
{{-- GLI DICO CHE POSSO FARE IL MERGE TRA LE CLASSI --}}
<div {{ $attributes->merge(['class' => 'alert alert-'.$info]) }} >
    {{$message}} by {{$name}}
</div>