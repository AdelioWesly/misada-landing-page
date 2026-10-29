import { describe, expect, it } from 'vitest'
import { mount } from '@vue/test-utils'
import LoadingState from './LoadingState.vue'

describe('LoadingState', () => {
  it('announces loading status politely', () => {
    const wrapper = mount(LoadingState)
    expect(wrapper.attributes('role')).toBe('status')
    expect(wrapper.attributes('aria-live')).toBe('polite')
    expect(wrapper.text()).toContain('Memuat informasi')
  })
})
