
export const DateFormater = {
  formate(dateString) {
// TODO: REMOVE AFTER DEBUG
// console.log('dts', dateString);
// TODO: REMOVE AFTER DEBUG

    if (!dateString) {
      return null
    }

    const date = new Date(dateString);

    try {
      const formatter = new Intl.DateTimeFormat('de-DE', {
        day: '2-digit',
        month: '2-digit',
        year: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        timeZone: 'Europe/Berlin'
      })

      return formatter.format(date.toLocaleString())
    } catch (err) {
      // TODO: REMOVE AFTER DEBUG
      // console.log('err2', err);
      // TODO: REMOVE AFTER DEBUG
      return null
    }
  },

  formateForHtml(dateString) {
    if (!dateString) {
      return null
    }

    const date = new Date(dateString)

    if (isNaN(date.getTime())) {
      return null
    }

    try {
      // Format as YYYY-MM-DDTHH:mm for datetime-local input
      const pad = (num) => String(num).padStart(2, '0')

      // Use local time for datetime-local input
      const year = date.getFullYear()
      const month = pad(date.getMonth() + 1)
      const day = pad(date.getDate())
      const hours = pad(date.getHours())
      const minutes = pad(date.getMinutes())

      return `${year}-${month}-${day}T${hours}:${minutes}`
    } catch (err) {
      return null
    }
  },
}
