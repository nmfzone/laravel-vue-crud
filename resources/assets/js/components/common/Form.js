import { Error } from '@common/Error'

export class Form {
  /**
   * Create a new Form instance.
   *
   * @param {object} data
   */
  constructor(data) {
    this.originalData = data

    for (let field in data) {
      this[field] = data[field]
    }

    this.errors = new Error()
  }

  /**
   * Fetch all relevant data for the form.
   */
  data() {
    let data = {}

    for (let property in this.originalData) {
      data[property] = this[property]
    }

    return data
  }

  /**
   * Reset the form fields.
   *
   * @param  {array}  fields
   */
  reset(fields = null) {
    for (let field in this.originalData) {
      if (fields === null || (fields !== null && fields.includes(field))) {
        this[field] = ''
      }
    }

    this.errors.clear()
  }

  /**
   * Send a POST request to the given URL.
   * .
   * @param {string} url
   */
  post(url) {
    return this.submit('post', url)
  }

  /**
   * Send a PUT request to the given URL.
   * .
   * @param {string} url
   */
  put(url) {
    return this.submit('put', url)
  }

  /**
   * Send a PATCH request to the given URL.
   * .
   * @param {string} url
   */
  patch(url) {
    return this.submit('patch', url)
  }

  /**
   * Send a DELETE request to the given URL.
   * .
   * @param {string} url
   */
  delete(url) {
    return this.submit('delete', url)
  }

  /**
   * Submit the form.
   *
   * @param {string} requestType
   * @param {string} url
   */
  submit(requestType, url) {
    return new Promise((resolve, reject) => {
        axios[requestType](url, this.data())
          .then(response => {
            this.onSuccess(response.data)

            resolve(response.data);
          })
          .catch(error => {
            this.onFail(error.response.data)

            reject(error.response.data)
          })
    })
  }

  /**
   * Handle a successful form submission.
   *
   * @param {object} data
   */
  onSuccess(data) {
    VueInstance.$data.alert.show = true
    VueInstance.$data.alert.type = 'success'
    VueInstance.$data.alert.message = ''
  }

  /**
   * Handle a failed form submission.
   *
   * @param {object} errors
   */
  onFail(errors) {
    VueInstance.$data.alert.type = 'danger'

    if (typeof errors.message !== 'undefined') {
      VueInstance.$data.alert.show = true

      if (errors.message !== null && errors.message !== '') {
        VueInstance.$data.alert.message = errors.message
      } else {
        VueInstance.$data.alert.message = 'Whoops! Something went wrong.'
      }
    }

    this.errors.record(errors)
  }
}
