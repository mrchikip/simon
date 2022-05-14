const express = require('express');
const router = express.Router();
const app = require("express")();
var moment = require('moment');
const { on } = require('../database');
moment().format();



const pool = require('../database');
//const { isLoggedIn } = require('../lib/auth');

function time_convert(mins) {
    let horas = Math.floor(mins / 60);
    let minutes = mins % 60;
    let fecha = new Date(Date.UTC(0, 0, 0, 0, mins));
    console.log(fecha);
    return horas + ":" + minutes;
}

router.get('/general', async (req, res) => {
    let list = [];
    const liveMachines = await pool.query('SELECT t1.dispositivo, registros.valor, t1.tiempo FROM ( SELECT dispositivo, MAX(tiempo) tiempo FROM registros GROUP BY dispositivo ) t1 INNER JOIN registros ON t1.dispositivo = registros.dispositivo AND t1.tiempo = registros.tiempo ORDER BY 1');

    //   let listaMaquinas = maqcards[];
    let n = 0;


    while (n < liveMachines.length) {

        var actividad =0;
        if(liveMachines[n].valor){
            var actividad = await pool.query('SELECT dispositivo, (NOW()- INTERVAL COUNT(1) MINUTE) AS ua FROM registros WHERE dispositivo = ? AND valor = 1 AND tiempo >=( SELECT MAX(tiempo) tiempo FROM registros WHERE dispositivo = ? AND valor = 0 ) GROUP BY dispositivo', [liveMachines[n].dispositivo, liveMachines[n].dispositivo]);
        } else {
            var actividad = await pool.query('SELECT dispositivo, (NOW()- INTERVAL COUNT(1) MINUTE) AS ua FROM registros WHERE dispositivo = ? AND valor = 0 AND tiempo >=( SELECT MAX(tiempo) tiempo FROM registros WHERE dispositivo = ? AND valor = 1 ) GROUP BY dispositivo', [liveMachines[n].dispositivo, liveMachines[n].dispositivo]);
        }

        const tiempo = moment(liveMachines[n].tiempo)
        const now = moment().subtract(0, 'minutes');
        const threshold = moment().subtract(3, 'minutes');
        var retraso = !tiempo.isBetween(threshold, now)

        //var lastUpdate = moment(liveMachines[n].tiempo);
        //var ahora = moment();
        //const desconexion = moment.unix(lastUpdate.diff(ahora))
        //const diff = desconexion.format('mm')

        if (retraso) {
            liveMachines[n].diferencia = false;
        } else {
            liveMachines[n].diferencia = true;
        }

        let maqcards = { ua:actividad[0].ua, dispositivo: liveMachines[n].dispositivo, valor: liveMachines[n].valor, tiempo: liveMachines[n].tiempo, diferencia: liveMachines[n].diferencia };
        list.push(maqcards);

        n++;
    }

    res.render('kaitiro/general', { list });

});

router.get('/detalle/:dispositivo', async (req, res) => {
    const { dispositivo } = req.params;
    const detalles = await pool.query('SELECT t1.dispositivo, registros.valor, t1.tiempo FROM ( SELECT dispositivo, MAX(tiempo) tiempo FROM registros WHERE dispositivo = ? GROUP BY dispositivo ) t1 INNER JOIN registros ON t1.dispositivo = registros.dispositivo AND t1.tiempo = registros.tiempo ORDER BY 1', [dispositivo]);

    res.render('kaitiro/detalle', { detalles: detalles[0] });
});








//router.post('/general', (req, res) => {
//    res.send('recibido');
//});

//router.post('/add', isLoggedIn, async (req, res) => {
//    const { tittle, url, description } = req.body;
//    const newLink = {
//        tittle,
//        url,
//        description,
//        user_id: req.user.id
//    };
//    await pool.query('INSERT INTO links set ?', [newLink]);
//    req.flash('success', 'link saved successfully');
//    res.redirect('/links');

//});

//router.get('/', isLoggedIn, async (req, res) => {
//    const links = await pool.query('SELECT * FROM links WHERE user_id = ?', [req.user.id]);
//    console.log(links);
//    res.render('links/list', {links});
//});

//router.get('/delete/:id', isLoggedIn, async (req, res) => {
//    const { id } = req.params;
//    await pool.query('DELETE FROM links WHERE ID = ?', [id]);
//    req.flash('success', 'link removed succesfully');
//    res.redirect('/links');
//});

//router.get('/edit/:id', isLoggedIn, async (req, res) => {
//    const { id } = req.params;
//    const links = await pool.query('SELECT * FROM links WHERE id = ?', [id]);
//    res.render('links/edit', {link: links[0]});
//} );

//router.post('/edit/:id', isLoggedIn, async (req, res) => {
//    const { id } = req.params;
//    const { tittle, description, url } = req.body;
//    const newLink = {
//        tittle,
//        description,
//        url
//    };
//    await pool.query('UPDATE links set ? WHERE id = ?', [newLink, id]);
//    req.flash('success', 'link updated successfully');
//    res.redirect('/links');
//}); 


module.exports = router;