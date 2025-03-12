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
             <th>{{ __('globle.coverbook') }}</th>
             <th>{{ __('globle.title') }}</th>
             {{-- <th>{{ __('globle.qty') }}</th>
             <th>{{ __('globle.price') }}</th> --}}
             <th>{{ __('globle.genres') }}</th>
             <th>{{ __('globle.action') }}</th>
          </tr>
       </thead>
       <tbody>

          @foreach ($books as $book)
              {{-- @foreach ($book->stocks as $stock) --}}
                <tr>
                   <td>
                      <div class="form-check">
                         <input class="form-check-input select-checkbox" type="checkbox" value="{{ $book->id }}" id="role_{{ $book->id }}" />
                         <label class="form-check-label" for="role_{{ $book->id }}"></label>

                      </div>
                   </td>
             
                   {{-- <td>{{ $book->id }}</td> --}}
                   <td>{{ $book->id }}</td>
                   <td>
                      <a href="#!"><img src="{{ Storage::url($book->cover_book) }}" alt="" class="icon-shape icon-md" /></a>
                   </td>

                   <td data-title-en="{{ $book->title_en }}" data-title-kh="{{ $book->title_en }}">
                      {{ $book->{'title_' . app()->getLocale()} }}
                   </td>

                  {{-- <td>{{ $stock->quantity }}</td>
                  <td>${{ $stock->selling_price }}</td> --}}
                  <td data-genres-id="{{ $book->genres_id }}">{{ $book->genres ? $book->genres->{'name_' . app()->getLocale()} : 'No Genres Assigned' }}</td>


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
                               <a class="dropdown-item btnEdit" href="#" data-id="{{ $book->id }}">
                                  <i class="bi bi-pencil-square me-3"></i>
                                  {{ __('globle.edit') }}
                               </a>
                            </li>
                         </ul>
                      </div>
                   </td>
                </tr>
             {{-- @endforeach --}}
          @endforeach

       </tbody>
    </table>
 </div>