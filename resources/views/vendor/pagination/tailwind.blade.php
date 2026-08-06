@if ($paginator->hasPages())
  <div class="flex items-center justify-end gap-2 mt-6">

    @if ($paginator->onFirstPage())
      <span class="px-3 py-2 rounded-lg bg-zinc-800 text-zinc-600 border border-zinc-700">
            Anterior
        </span>
    @else
      <a href="{{ $paginator->previousPageUrl() }}"
         class="px-3 py-2 rounded-lg border border-zinc-700 text-zinc-300 hover:bg-zinc-700 transition">
        Anterior
      </a>
    @endif


    @foreach ($elements as $element)

      @if (is_string($element))
        <span class="px-3 py-2 text-zinc-500">
                {{ $element }}
            </span>
      @endif


      @if (is_array($element))
        @foreach ($element as $page => $url)

          @if ($page == $paginator->currentPage())
            <span class="px-3 py-2 rounded-lg text-black font-semibold"
                  style="background:#D4A870;">
                        {{ $page }}
                    </span>
          @else
            <a href="{{ $url }}"
               class="px-3 py-2 rounded-lg border border-zinc-700 text-zinc-300 hover:bg-zinc-700 transition">
              {{ $page }}
            </a>
          @endif

        @endforeach
      @endif

    @endforeach


    @if ($paginator->hasMorePages())
      <a href="{{ $paginator->nextPageUrl() }}"
         class="px-3 py-2 rounded-lg border border-zinc-700 text-zinc-300 hover:bg-zinc-700 transition">
        Siguiente
      </a>
    @else
      <span class="px-3 py-2 rounded-lg bg-zinc-800 text-zinc-600 border border-zinc-700">
            Siguiente
        </span>
    @endif

  </div>
@endif
