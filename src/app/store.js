import {configureStore} from '@reduxjs/toolkit';
import counterReducer from '../features/counter/counterSlice';

//// in the store we will have what the user can change
// const exampleStore = {
//     last_visited: {
//         pokedex_entry:  null,
//         team: null,
//         // etc.
//     },
//     options: {
//         sort_by: "NATIONAL_DEX|ALPHABETICAL|EVOLUTION_FORM",
//         sort_order: "ASC|DESC",
//         include_female_forms: true,
//         include_cosmetic_forms: true,
//         include_special_ability_forms: true,
//         include_shiny: true,
//         // ... etc
//     },
//     home_storage: [ // list of all the HOME-storable forms
//         // tracker for: captured/not-captured, marks, pokeballs, origin game, moves, nature, ability, evs, etc.
//         // JUST HOLDS metadata and poke identifiers, the static pokemon data is loaded from JSON files/API
//     ],
//     go_storage: [], // list of all GO-storable pokes, with user-metadata. // JUST HOLDS metadata and poke identifiers
//     teams: [ // l
//         {
//             // koffing JSON
//         }
//     ],
//     rulesets: {
//         "swsh-season10": {}
//     }
// }

export default configureStore({
    reducer: {
        counter: counterReducer,
    },
});
