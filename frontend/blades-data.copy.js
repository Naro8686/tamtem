const fs = require ('fs-extra');
const path_from = './src/forblades';
const path_to = '../public/forblades';
fs.copy(path_from,path_to,err=>{
    if (err) { return console.error(err)}
    console.log('Copying blade data succesfully!')
});