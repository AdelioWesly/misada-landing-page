const referenceBase = (import.meta.env.VITE_REFERENCE_BASE_URL || 'https://web.misada.sch.id').replace(/\/$/, '')

export const referenceUrl = (path: string) => `${referenceBase}/${path.replace(/^\//, '')}`

export const referenceLinks = {
  alumni: referenceUrl('/alumni'),
  downloads: referenceUrl('/download'),
  contact: referenceUrl('/hubungi'),
  logo: referenceUrl('/asset/logo/MISADA1.png'),
}
