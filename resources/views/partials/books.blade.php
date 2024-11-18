@php
    use Picqer\Barcode\BarcodeGeneratorHTML;

    // Initialize the barcode generator
    $generator = new BarcodeGeneratorHTML();
@endphp
@foreach($books as $book)
@foreach($book->stocks as $stock)
<div class="col">
    <div class="card card-product">
        <div class="card-body">
            <div class="text-center position-relative" style="cursor: pointer">
                <div class="position-absolute top-0 start-0">
                    <span class="badge bg-danger">${{ $stock->selling_price }}</span>
                </div>
                <div>
                    <img src="{{ Storage::url($book->cover_book) }}" alt="{{ $book->title_en }}"
                         class="add-to-cart-button mb-3 img-fluid"
                         data-book-id="{{ $book->id }}" data-stock-id="{{ $stock->id }}" />
                </div>
            </div>
            <div class="text-small mb-1">
                <a href="#!" class="text-decoration-none text-muted"><small>{{ $book->genres->{'name_' . app()->getLocale()} }}</small></a>
             </div>
            <h2 class="fs-6">
                <a href="#" class="text-inherit text-decoration-none">{{ $book->{'title_' . app()->getLocale()} }}</a>
            </h2>
            <div style="transform: scale(0.7); transform-origin: 0 0;">
                {!! $generator->getBarcode($book->barcode, $generator::TYPE_CODE_128) !!}
                <h5>p - {{ $book->barcode }}</h5>
            </div>

        </div>
    </div>
</div>
@endforeach
@endforeach
