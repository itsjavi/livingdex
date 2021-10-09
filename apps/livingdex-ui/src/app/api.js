const PokeApiDefaultBaseUrl = process.env.PUBLIC_URL + "/assets/data/json"
const PokeApiMaxGen = 8

class PokeApi {
  #baseUrl
  #generation

  constructor(generation = PokeApiMaxGen, baseUrl = PokeApiDefaultBaseUrl) {
    this.#generation = generation
    this.#baseUrl = baseUrl
  }

  get generation() {
    return this.#generation
  }

  set generation(value) {
    this.#generation = value
  }

  get baseUrl() {
    return this.#baseUrl
  }

  set baseUrl(value) {
    this.#baseUrl = value
  }

  /**
   * @param {string} resource
   * @returns {Promise<any>}
   */
  async _getJson(resource) {
    return fetch(this.#baseUrl + "/" + resource + ".json").then((res) =>
      res.json(),
    )
  }

  /**
   * @returns {Promise<PokemonListItem[]>}
   */
  async getPokemonList() {
    return this._getJson(`gen/${this.generation}/pokemon-forms`)
  }

  async getPokemon(slug, withLearnset = false) {
    let pkm = this._getJson(`gen/${this.generation}/pokemon/${slug}`)

    if (withLearnset) {
      pkm
        .then((entry) => {
          return Promise.all([entry, this.getLearnset(slug)])
        })
        .then((resolutions) => {
          let entry = resolutions[0]
          entry.learnset = resolutions[1]
        })
    }

    return pkm
  }

  /**
   * @param {string} slug
   * @returns {Promise<any>}
   */
  async getLearnset(slug) {
    return this._getJson(`gen/${this.generation}/learnsets/${slug}`)
  }

  /**
   * @returns {Promise<any>}
   */
  async getMoves() {
    return this._getJson(`gen/${this.generation}/moves`)
  }

  /**
   * @param {string} name
   * @returns {Promise<any>}
   */
  async getMove(name) {
    return this.getMoves().then((entries) => entries[name])
  }

  /**
   * @returns {Promise<any>}
   */
  async getItems() {
    return this._getJson(`gen/${this.generation}/items`)
  }

  /**
   * @param {string} name
   * @returns {Promise<any>}
   */
  async getItem(name) {
    return this.getItems().then((entries) => entries[name])
  }

  /**
   * @returns {Promise<any>}
   */
  async getAbilities() {
    return this._getJson(`gen/${this.generation}/abilities`)
  }

  /**
   * @returns {Promise<any>}
   */
  async getGames() {
    return this._getJson(`games`)
  }

  /**
   * @param {string} name
   * @returns {Promise<any>}
   */
  async getAbility(name) {
    return this.getAbilities().then((entries) => entries[name])
  }

  /**
   * @returns {Promise<any>}
   */
  async getTypes() {
    return this._getJson("types")
  }

  /**
   * @returns {Promise<any>}
   */
  async getEggGroups() {
    return this._getJson("egg-groups")
  }

  /**
   * @returns {Promise<any>}
   */
  async getNatures() {
    return this._getJson("natures")
  }
}

export default PokeApi
export { PokeApi, PokeApiMaxGen }
