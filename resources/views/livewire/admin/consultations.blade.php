<div class="col-md-12 col-sm-12 mt-3">
    <div class="white-shadow-third-box">
        <h2 class="text-center">Consultations</h2>
        <div class="lawyer_conultation-wrapper">
          
            <div class="tabs_design-wrap three_tabs-layout">
                <div class="lawyer-tabs_lists">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link{{ @$title['active']=='upcoming' ? ' active':'' }}" wire:click="upcomingConsultations()">Upcoming</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ @$title['active']=='complete' ? ' active':'' }}" wire:click="completeConsultations('complete')">Complete</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ @$title['active']=='accepted' ? ' active':'' }}" wire:click="acceptConsultations('accepted')">Cases</a>
                        </li>
                    </ul>
                </div>

                <div class="lawyer-tabs_contents">

                    <div class="tab-content">

                  
                        @if(@$upcomingTab=='true')
                        @include('livewire.admin.consultation.upcoming')
                        @endif

                        @if(@$completeTab=='true')
                        @include('livewire.admin.consultation.complete')
                        @endif

                        @if(@$acceptTab=='true')
                        @include('livewire.admin.consultation.accept')
                        @endif

                      
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>