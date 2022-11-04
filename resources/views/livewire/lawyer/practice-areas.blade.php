<div>
    <div class="form-grouph view_practice-area">
        <button type="button" class="btn-design-second showModal">Select Practice areas</button>
    </div>



    <div wire:ignore.self class="modal fade show in" id="practiceModal" tabindex="-1" role="dialog" aria-labelledby="practiceModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                <div class="modal-body">
                    <div class="heading-paragraph-design text-center position-relative go-back-wrap">
                        <h2>Areas of Practice</h2>
                        <p>Edit or change practice areas</p>
                    </div>
                    <div class="tabs_design-wrap two_tabs-layout">
                        <div class="area_practice_lists">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ $currentTab=='litigations' ? 'active' : '' }}" href="javascript:void(0)" wire:click="setCurrentTab('litigations')">Litigation</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ $currentTab=='contracts' ? 'active' : '' }}" href="javascript:void(0)" wire:click="setCurrentTab('contracts')">Transactional</a>
                                </li>
                            </ul>
                        </div>
                        <div class="area_practice_fields">
                            <form class="form-design">
                                <div class="tab-content">
                                    
                                    @if($currentTab=='litigations')
                                    <div id="litigations" class="container tab-pane active">
                                        <div class="row">
                                            
                                            @php
                                                $count = count($litigations) / 2;
                                                $count = number_format($count);
                                            @endphp

                                            @foreach ($litigations->chunk($count) as $chunk)
                                            <div class="col-md-6">
                                                @foreach ($chunk as $j =>  $litigation)
                                                <div class="form-grouph checkbox-design position-relative">
                                                    <input type="checkbox" value="{{ $litigation->id }}" wire:model="selectLitigations.{{$j}}">
                                                    <button class="checkbox-btn"></button>
                                                    <label>{{ @$litigation->name }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endforeach
                                        </div>
                                        {!! $errors->first('selectLitigations', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    @endif

                                    @if($currentTab=='contracts')
                                    <div id="contracts" class="container tab-pane active"><br>
                                        <div class="row">
                                            @php
                                                $countCon = count($contracts) / 2;
                                                $countCon = number_format($countCon);
                                            @endphp

                                            @foreach ($contracts->chunk($countCon) as $chunk)
                                            <div class="col-md-6">
                                                @foreach ($chunk as $i => $contract)
                                                    <div class="form-grouph checkbox-design position-relative">
                                                        <input type="checkbox" value="{{ $contract->id }}" wire:model="selectContracts.{{$i}}">
                                                        <button class="checkbox-btn"></button>
                                                        <label>{{ @$contract->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @endforeach
                                        </div>
                                        {!! $errors->first('selectContracts', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    @endif

                                    <div class="text-center mt-5">
                                        <div class="form-grouph submit-design text-center">
                                            <button type="button" class="btn-design-first" wire:click="store" wire:loading.attr="disabled">
                                                <i wire:loading wire:target="store" class="fa fa-spin fa-spinner"></i> Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            window.livewire.on('practiceFormModalHide', () => {
                $('#practiceModal').modal('hide');
            });
        });

        $(document).on('click', '.showModal', function(e) {
            $('#practiceModal').modal('show');
        });
        $(document).on('click', '.closeModal', function(e) {
            $('#practiceModal').modal('hide');
        });
    </script>
    @endpush
</div>