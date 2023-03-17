{{-- Pager --}}

<nav class="d-flex justify-items-center justify-content-between">

  {{-- For modile --}}
  <div class="d-flex justify-content-between flex-fill d-sm-none">
    <ul class="pagination">

    @if( $links['prev'] == null)
      <li class="page-item disabled" aria-disabled="true">
        <span class="page-link">« Previous</span>
      </li>
    @else
    <li class="page-item">
      <a class="page-link carrent-page" href="{{ $links['prev'] }}" rel="prev">« Previous</a>
    </li>
    @endif

    @if( $links['next'] == null)
      <li class="page-item disabled" aria-disabled="true">
        <span class="page-link">Next »</span>
      </li>
    @else
      <li class="page-item">
        <a class="page-link carrent-page" href="{{ $links['next'] }}" rel="next">Next »</a>
      </li>
    @endif
    </ul>
  </div>

  <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
    <div>
      <p class="small text-muted">
        Показано с
        <span class="fw-semibold">{{ $meta['from'] }}</span>
        по
        <span class="fw-semibold">{{ $meta['to'] }}</span>
        из
        <span class="fw-semibold">{{ $meta['total'] }}</span>
        задач
      </p>
    </div>

    {{-- Pagination --}}
    <div>

      <ul class="pagination">

        {{-- Previous link --}}
        @if( $links['prev'] == null)
          <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
            <span class="page-link" aria-hidden="true">‹</span>
          </li>
        @else
        <li class="page-item">
            <a class="page-link carrent-page" href="{{ $links['prev'] }}" rel="prev" aria-label="« Previous">‹</a>
          </li>
        @endif

        {{-- Existing links --}}
          @foreach($meta['links'] as $link)
            @if ($link['label'] != "&laquo; Previous" && $link['label'] != "Next &raquo;")

              @if ($link['active'] == 'active')
                <li class="page-item active" aria-current="page"><span class="page-link">{{ $meta['current_page'] }}</span></li>
              @else

                <li class="page-item">
                  <a class="page-link carrent-page" href="{{ $link['url'] }}"><?= $link['label'] ?></a>
                </li>
              @endif

            @endif
          @endforeach

        {{-- Next link --}}

          @if( $links['next'] == null)
            <li class="page-item disabled" aria-disabled="true" aria-label="Next »">
              <span class="page-link" aria-hidden="true">›</span>
            </li>
          @else
            <li class="page-item">
              <a class="page-link carrent-page" href="{{ $links['next'] }}" rel="next" aria-label="Next »">›</a>
            </li>
          @endif

        </ul>
    </div>
  </div>
</nav>