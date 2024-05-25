@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page title here')
@section('content')
@livewire('admin-categories-subcategories-list')
@endsection

@push('scripts')
<script>
    $('table tbody#sortable_categories').sortable({
        cursor:'move',
        update:function(event,ui){
            $(this).children().each(function(index){
                if($(this).attr('data-ordering') != (index+1)){
                    $(this).attr('data-ordering',(index+1)).addClass('updated');
                }
            });
            var positions = [];
            $('.updated').each(function(){
                positions.push([$(this).attr('data-index'),$(this).attr('data-ordering')]);
                $(this).removeClass('updated');
            });
            window.livewire.emit('updateCategoriesOrdering',positions);
        }
    });  //ask sir
</script>
@endpush