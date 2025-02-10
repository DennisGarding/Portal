import axios from 'axios'
import Message from '@/Class/Base/Message.js'

export default class AccordionStateRepository {
  constructor(mainStore) {
    this.client = axios
    this.mainStore = mainStore
  }

  loadAccordionState() {
    this.mainStore.setLoading()
    this.client
      .get('/call/accordion/state/load')
      .then((response) => {
        this.mainStore.initAccordionStates(response.data)
        this.mainStore.unsetLoading()
      })
      .catch((error) => {
        this.mainStore.addStickyMessage(
          new Message('Error', 'Could not load Accordion-States', error),
        )

        this.mainStore.unsetLoading()
      })
  }

  saveAccordionState() {
    const data = { state: JSON.stringify(this.mainStore.accordionStates) }

    this.client.post('/call/accordion/state/save', data).catch((error) => {
      this.mainStore.addStickyMessage(
        new Message('Error', 'Could not save Accordion-States', error),
      )
    })
  }
}
