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

$(document).on('click','.deleteCategoryBtn',function(){
    e.preventDefault();
    var category_id = $(this).data('id');
    swal.fire({
        title:'Are you sure?',
        html:'You want to delete this category',
        showCloseButton:true,
        showCancelButton:true,
        cancelButtonText:'Cancel',
        confirmButtonText:'Yes, Delete',
        cancelButtonColor:'#d33',
        confirmButtonColor:'#3085d6',
        width:300,
        allowOutsideClick:false
    }).then(function(result){
        if(result.value){
            window.livewire.emit('deleteCategory',category_id);
        }
    });
});

$('table tbody#sortable_subcategories').sortable({
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
        window.livewire.emit('updateSubCategoriesOrdering',positions);
    }
});  //ask sir

$('ul#sortable_child_subcategories').sortable({
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
        window.livewire.emit('updateChildSubCategoriesOrdering',positions);
    }
});
</script>
@endpush