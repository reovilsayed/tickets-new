<div class="row">
    <div class="col-md-4">
        <label for="" class="form-label">Name</label>
        <input type="text" name="name" id="name" value="{{ $shop->user ? $shop->user->name : old('name') }}"
            class="form-control @error('name')  is-invalid @enderror">
        @error('name')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-4">
        <label for="" class="form-label">Email</label>
        <input type="text" name="email" id="email" value="{{ $shop->user ? $shop->user->email : old('email') }}"
            class="form-control @error('email')  is-invalid @enderror" {{$shop->user ? $shop->user->email ? 'readonly' :''  : ''}}>
        @error('email')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-4">
        <label for="shop_name" class="form-label">Shop name</label>
        <input type="text" name="shop_name" id="shop_name" value="{{ $shop->name ? $shop->name : old('shop_name') }}"
            class="form-control @error('shop_name')  is-invalid @enderror">
        @error('shop_name')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
   
    <div class="col-md-6">
        @if($shop->logo)
        <img src="{{Voyager::image($shop->logo)}}" alt="" height="50">
        @endif
        <label for="shop_name" class="form-label">Logo</label>
        <input type="file" name="logo" id="logo"
            class="form-control @error('logo')  is-invalid @enderror" value="{{$shop->logo ? $shop->logo :''}}">
        @error('logo')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
 
    <div class="col-md-6">
        @if($shop->banner)
        <img src="{{Voyager::image($shop->banner)}}" alt="" height="50">
        @endif
        <label for="cover" class="form-label">Cover (optinal)</label>
        <input type="file" name="cover" id="cover"
            class="form-control @error('cover')  is-invalid @enderror" value="{{$shop->banner ? $shop->banner :''}}">
        @error('cover')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-4">
        <label for="city" class="form-label">City</label>
        <input type="text" name="city" id="shop_name" value="{{ $shop->city ? $shop->city : old('city') }}"
            class="form-control @error('city')  is-invalid @enderror">
        @error('city')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-4">
        <label for="state" class="form-label">State</label>
        <input type="text" name="state" id="state" value="{{ $shop->state ? $shop->state : old('state') }}"
            class="form-control @error('state')  is-invalid @enderror">
        @error('state')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-4">
        <label for="country" class="form-label">Country</label>
        <input type="text" name="country" id="country" value="{{ $shop->country ? $shop->country : old('country') }}"
            class="form-control @error('country')  is-invalid @enderror">
        @error('country')
            <span class="invalid-feedback text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

</div>
<button type="submit" class="btn btn-primary">Save</button>
