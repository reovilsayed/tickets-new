<select class="form-select  @error('meta.country') is-invalid @enderror" name="meta[country]"
    id="country" value="" required>
    <option selected>Choose Country</option>
        <option value="Denmark" {{ auth()->user()->country == 'Denmark' ? 'selected' : '' }}>Denmark</option>  
   </select>
@error('country')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
