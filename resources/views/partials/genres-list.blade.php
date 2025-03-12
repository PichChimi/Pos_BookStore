<div class="table-responsive">
    <table id="dataTable" class="table table-centered table-hover mb-0 text-nowrap table-borderless table-with-checkbox">
       <thead class="bg-light">
          <tr>
             <th>
                <div class="form-check">
                   <input class="form-check-input" type="checkbox" value="" id="checkAll" />
                   <label class="form-check-label" for="checkAll"></label>
                </div>

             </th>
             <th>{{ __('globle.no') }}</th>
             <th>{{ __('globle.name') }}</th>
             <th>{{ __('globle.action') }}</th>
          </tr>
       </thead>
       <tbody>

          @foreach ($genress as $genres)
                <tr>
                   <td>
                      <div class="form-check">
                         <input class="form-check-input select-checkbox" type="checkbox" value="{{ $genres->id }}" id="role_{{ $genres->id }}" />
                         <label class="form-check-label" for="role_{{ $genres->id }}"></label>

                      </div>
                   </td>
             
                   <td>{{ $genres->id }}</td>

                   <td data-name-en="{{ $genres->name_en }}" data-name-kh="{{ $genres->name_kh }}">
                      {{ $genres->{'name_' . app()->getLocale()} }}
                   </td>

                   <td>
                      <div class="dropdown">
                         <a href="#" class="text-reset" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="feather-icon icon-more-vertical fs-5"></i>
                         </a>
                         <ul class="dropdown-menu">
                            <li>
                               <a class="dropdown-item btnDelete" href="#">
                                  <i class="bi bi-trash me-3 text-danger"></i>
                                  <span class="text-danger">{{ __('globle.delete') }}</span>
                               </a>
                            </li>
                            <li>
                               <a class="dropdown-item btnEdit" href="#">
                                  <i class="bi bi-pencil-square me-3"></i>
                                  {{ __('globle.edit') }}
                               </a>
                            </li>
                         </ul>
                      </div>
                   </td>
                </tr>
          @endforeach

       </tbody>
    </table>
 </div>