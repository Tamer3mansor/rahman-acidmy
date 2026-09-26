@php
    $searchAction ??= route('blog.index');
    $searchTerm ??= null;
    $searchHidden ??= [];
    $searchClearUrl ??= $searchAction;
    $searchPlaceholder ??= 'Rechercher…';
@endphp
<form action="{{ $searchAction }}" method="GET" class="search-bar" role="search">
    @foreach ($searchHidden as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
    @endforeach

    <span class="search-bar-icon" aria-hidden="true"><i class="fa-solid fa-magnifying-glass"></i></span>

    <input
        type="search"
        name="q"
        class="search-bar-input"
        value="{{ $searchTerm }}"
        placeholder="{{ $searchPlaceholder }}"
        aria-label="{{ $searchPlaceholder }}"
        autocomplete="off"
    >

    @if ($searchTerm !== null)
        <a href="{{ $searchClearUrl }}" class="search-bar-clear" aria-label="Effacer la recherche">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </a>
    @endif

    <button type="submit" class="search-bar-btn" aria-label="Rechercher">
        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
        <span class="search-bar-btn-label">Rechercher</span>
    </button>
</form>
