import contextMenu from "@/components/Base/ContextMenu.vue";

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
        timeZone: 'Germany/Berlin'
      })

      return formatter.format(date.toLocaleString())
    } catch (err) {
      // TODO: REMOVE AFTER DEBUG
      // console.log('err2', err);
      // TODO: REMOVE AFTER DEBUG
    }

  },

  formateForHtml(dateString) {
    if (!dateString) {
      return null
    }

    dateString = new Date(dateString).toLocaleString()

    return dateString
  },
}
