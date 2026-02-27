<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-8 py-3 bg-indigo-600 border-none rounded-2xl font-black text-xs text-white uppercase tracking-widest hover:bg-indigo-700 hover:shadow-2xl hover:shadow-indigo-500/40 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-indigo-500/20 transition-all duration-200 shadow-xl shadow-indigo-500/20']) }}>
    {{ $slot }}
</button>
