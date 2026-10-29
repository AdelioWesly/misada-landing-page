import { beforeEach, describe, expect, it } from 'vitest'
import router from './index'

describe('public router', () => {
  beforeEach(async () => {
    await router.push('/')
  })

  it('maps public modules to their expected route metadata', async () => {
    await router.push('/berita')
    expect(router.currentRoute.value.meta.collection).toBe('news')

    await router.push('/sarana-prasarana')
    expect(router.currentRoute.value.meta.collection).toBe('facilities')

    await router.push('/berita/contoh-slug')
    expect(router.currentRoute.value.meta.detail).toBe('news')
  })

  it('routes unknown paths to the 404 page', async () => {
    await router.push('/alamat-tidak-ada')
    expect(router.currentRoute.value.name).toBe('not-found')
  })
})
