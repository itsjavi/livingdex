import fs from "fs"
import path from "path"
import { URL } from "url"

const __filename = new URL("", import.meta.url).pathname
const __dirname = new URL(".", import.meta.url).pathname
const MAX_GEN = 8
const DATA_DIR = path.resolve(__dirname + "/../../ui/public/assets/data/json")

if (!fs.existsSync(DATA_DIR + "/gen")) {
  throw new Error("gen path does not exist")
}

function PokeNameToTitle(pkm) {
  let str = pkm.name.replace(/-F$/gi, " (Female)")
    .replace(/-Gmax$/gi, " (Gigantamax)")
    .replace(/-(.*)/gi, " ($1)")
    .replace(/-/gi, " ")


  if (
    pkm.veekunSlug !== undefined
    && pkm.veekunSlug !== null
    && pkm.veekunSlug.match(/-cap$/i)
  ) {
    str = str.replace(/\)$/gi, " Cap)")
  }

  return str
}

function loadJsonFile(relativePath) {
  let jsonFile = DATA_DIR + `/` + relativePath
  if (!fs.existsSync(jsonFile)) {
    throw new Error("JSON file does not exist: " + jsonFile)
  }
  return JSON.parse(fs.readFileSync(jsonFile).toString())
}

function loadPokemonFormsIndex(gen) {
  return loadJsonFile(`gen/${gen}/pokemon-forms.json`)
}

function storePokemonFormsIndex(gen, data) {
  const jsonStr = JSON.stringify(data, null, 2)
  fs.writeFileSync(DATA_DIR + `/gen/${gen}/livingdex-pokemon.json`, jsonStr)
}

function storePokemonDetails(gen, slug, data) {
  const jsonStr = JSON.stringify(data, null, 2)
  fs.writeFileSync(DATA_DIR + `/gen/${gen}/pokemon/${slug}.json`, jsonStr)
}

function loadPokemonData(gen, slug) {
  return loadJsonFile(`gen/${gen}/pokemon/${slug}.json`)
}

for (const g of Array(MAX_GEN).keys()) {
  let gen = g + 1

  console.log(`Processing generation ${gen}...`)

  let pokemonForms = loadPokemonFormsIndex(gen)

  pokemonForms.forEach((pkmListItem, i, items) => {

    let pkm = loadPokemonData(gen, pkmListItem.slug)

    if (pkm.baseDataForm !== null) {
      pkm = Object.assign({}, loadPokemonData(gen, pkm.baseDataForm), pkm)
    }

    pkm.title = items[i].title = PokeNameToTitle(pkm)
    items[i].baseSpecies = pkm.baseSpecies
    items[i].baseDataForm = pkm.baseDataForm
    items[i].imgSprite = pkm.imgSprite
    items[i].imgHome = pkm.imgHome
    items[i].formOrder = pkm.formOrder
    items[i].isBaseSpecies = (pkm.baseSpecies === null)
    items[i].isForm = (pkm.baseSpecies !== null)
    items[i].isCosmetic = pkm.isCosmetic
    items[i].isGmax = pkm.isGmax
    items[i].isHomeStorable = pkm.isHomeStorable
    items[i].type1 = pkm.type1 || null
    items[i].type2 = pkm.type2 || null
    items[i].baseStats = pkm.baseStats || null
    items[i].veekunSlug = pkm.veekunSlug || null

    storePokemonDetails(gen, pkmListItem.slug, pkm)
  })

  storePokemonFormsIndex(gen, pokemonForms)
}
