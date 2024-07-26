<!-- Delete Button Component -->
@props([
    'route' => '',
    'confirmMessage' => 'Are you sure you want to delete this item?',
    'method' => 'DELETE',
    'btnClasses' => 'btn btn-warning',
    
])

<form action="{{ $route }}" method="POST" style="display:inline-block;">
    @csrf
 
    <button type="submit" class="{{ $btnClasses }}" onclick="return confirm('{{ $confirmMessage }}');">
        <i class="fa-solid fa-trash"></i>
    </button>
</form>
