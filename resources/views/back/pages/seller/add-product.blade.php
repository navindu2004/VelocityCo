@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page title here')
@section('content')

<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>New Product</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="{{ route('seller.home') }}">Home</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											New Product
										</li>
									</ol>
								</nav>
							</div>
							<div class="col-md-6 col-sm-12 text-right">
								<a href="{{ route('seller.product.all-products') }}" class="btn btn-primary">View all products</a>
							</div>
						</div>
					</div>

<form action="{{ route('seller.product.create-product') }}" method="POST" enctype="multipart/form-data" id="addProductForm">
@csrf
<div class="row pd-10">
    <div class="col-md-8 mb-20">
        <div class="card-box height-100-p pd-20" style="position:relative">
        <div class="form-group">
            <label for=""><b>Product Name:</b></label>
            <input type="text" class="form-control" name="name" placeholder="Enter product name">
            <span class="text-danger error-text name_error"></span>
        </div>
        <div class="form-group">
            <label for=""><b>Product Summary:</b></label>
            <textarea id="summary" class="form-control" cols="30" rows="10"></textarea>
            <span class="text-danger error-text summary_error"></span>
        </div>
        <div class="form-group">
            <label for=""><b>Product Image:</b><small>Must be square and maximum dimension of (1080x1080)</small></label>
            <input type="file" name="product_image" class="form-control">
            <span class="text-danger error-text product_image_error"></span>
        </div>
       
        </div>
    </div>
    <div class="col-md-4 mb-20">
        <div class="card-box min-height-200px pd-20 mb-20">
            <div class="form-group">
                <label for=""><b>Category:</b></label>
                <select name="category" id="category" class="form-control">
                    <option value="" selected>Not Set</option>
                    @foreach ($categories as $item)
                        <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                    @endforeach
                </select>
                <span class="text-danger error-text category_error"></span>
            </div>

            <div class="form-group">
                <label for=""><b>Sub Category:</b></label>
                <select name="subcategory" id="subcategory" class="form-control">
                    <option value="" selected>Not Set</option>
                </select>
                <span class="text-danger error-text subcategory_error"></span>
            </div>
        </div>
        <div class="card-box min-height-200px pd-20 mb-20">
        <div class="form-group">
                <label for=""><b>Price:</b><small>In Sri Lankan Rupees (Rs.)</small></label>
                <input type="text" name="price" class="form-control" placeholder="Eg: 300,000">
                <span class="text-danger error-text price_error"></span>
            </div>
            <div class="form-group">
                <label for=""><b>Compare Price:</b><small>Optional</small></label>
                <input type="text" name="compare_price" class="form-control" placeholder="Eg: 500,000">
                <span class="text-danger error-text compare_price_error"></span>
            </div>
        </div>
        <div class="card-box min-height-120px pd-20">
            <div class="form-group">
                <label for=""><b>Visibility:</b></label>
                <select name="visibility" id="" class="form-control">
                    <option value="1" selected>Public</option>
                    <option value="0">Private</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <button class="btn btn-primary" type="submit">Create Product</button>
</div>
</form>

@endsection
@push('scripts')
<script>
    //list sub categories according to the selected category
    $(document).on('change','select#category', function(e){
        e.preventDefault();
        var category_id = $(this).val();
        var url = "{{ route('seller.product.get-product-category')}}";
        if( category_id == '' ){
            $("select#subcategory").find("option").not(":first").remove();
        }else{
            $.get(url, {category_id:category_id}, function(response){
                $("select#subcategory").find("option").not(":first").remove();
                $("select#subcategory").append(response.data);
            },'JSON');
        }
    });
</script>