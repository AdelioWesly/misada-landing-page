import { describe, expect, it } from 'vitest'
import { mount } from '@vue/test-utils'
import EmptyState from './EmptyState.vue'

describe('EmptyState', () => {
  it('renders a useful default message', () => {
    const wrapper = mount(EmptyState)
    expect(wrapper.text()).toContain('Belum ada informasi')
    expect(wrapper.text()).toContain('Belum ada konten')
  })

  it('renders caller-provided state text', () => {
    const wrapper = mount(EmptyState, { props: { title: 'Agenda kosong', message: 'Tidak ada agenda.' } })
    expect(wrapper.text()).toContain('Agenda kosong')
    expect(wrapper.text()).toContain('Tidak ada agenda.')
  })
})
