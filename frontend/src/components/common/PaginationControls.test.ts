import { describe, expect, it } from 'vitest'
import { mount } from '@vue/test-utils'
import PaginationControls from './PaginationControls.vue'

describe('PaginationControls', () => {
  it('disables previous on the first page and emits the next page', async () => {
    const wrapper = mount(PaginationControls, { props: { currentPage: 1, lastPage: 3 } })
    const buttons = wrapper.findAll('button')

    expect(buttons[0].attributes('disabled')).toBeDefined()
    expect(buttons[1].text()).toBe('Berikutnya')
    await buttons[1].trigger('click')
    expect(wrapper.emitted('change')).toEqual([[2]])
  })

  it('does not render when there is only one page', () => {
    const wrapper = mount(PaginationControls, { props: { currentPage: 1, lastPage: 1 } })
    expect(wrapper.find('nav').exists()).toBe(false)
  })
})
