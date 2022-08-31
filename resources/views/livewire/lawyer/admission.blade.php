<div>
    <div class="lawyer_profile-wrapper">
    	<div class="row">
		    <form >

				<div class="form-grouph select-design">
				    @foreach ($categoriesMulti as $category)
				    <div class="form-grouph input-design">
				        <label>{{ $category->name }}*</label>
				    </div>
				    <select class="select-block-multi" name="admissionArray[{{$category->id}}]" data-name="admissionArray.{{$category->id}}" wire:model="admissionArray.{{$category->id}}" multiple>
				        @foreach($category->items as $i => $list)
				            <option value="{{$list->id}}">
				                {{$list->name}}
				            </option>
				        @endforeach
				    </select>
				    {!! $errors->first('lawyer_info', '<span class="help-block">:message</span>') !!}
				    @endforeach
				</div>


				
		        <div class="mt-5">
		            <div class="form-grouph submit-design">
		                <button type="button" class="btn-design-first" wire:click="storeAdmission" wire:loading.attr="disabled">
		                    <i wire:loading wire:target="storeAdmission" class="fa fa-spin fa-spinner"></i> Save
		                </button>
		            </div>
		        </div>

			</form>
		</div>
	</div>



    @push('scripts')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<style>
		.select2-container {
			width: 100% !important;
		}
	</style>
    <script>
        $(document).ready(function() {
        	$('.select-block-multi').select2();

        	window.livewire.on('fireSelect', () => {
        		console.log('d');
                $('.select-block-multi').select2();
            });

            $(document).on('change', '.select-block-multi', function (e) {
				var data = $(this).select2("val");
				var name = $(this).attr("data-name");

				@this.set(name, data);
				@this.set('itemArray', data);

			});
        });

    </script>
    @endpush
</div>