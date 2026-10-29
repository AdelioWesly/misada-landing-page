<template>
  <main id="main-content" class="mx-auto w-full max-w-4xl px-5 py-16 sm:px-8" tabindex="-1">
    <section class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
      <p class="text-sm font-semibold uppercase tracking-[0.2em] text-blue-700">404</p>
      <h1 class="mt-3 text-3xl font-bold text-slate-900">Halaman tidak ditemukan</h1>
      <p class="mt-3 text-slate-600">Alamat yang Anda buka tidak tersedia.</p>
      <RouterLink
        class="mt-6 inline-flex rounded-lg bg-blue-700 px-4 py-2.5 font-semibold text-white hover:bg-blue-800"
        to="/"
      >
        Kembali ke Beranda
      </RouterLink>
    </section>
  </main>
</template>
