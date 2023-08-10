const express = require('express')
const Sequelize = require('sequelize')
const app = express()
const { faker } = require('@faker-js/faker');

//Parámetros para la conexión con la base de datos
const sequelize = new Sequelize('abarrotes', 'root','',{
    host: 'localhost',
    port: '3310',
    dialect: 'mysql'
})

//Se define el modelo para la tabla clientes
const nombresModel = sequelize.define('clientes',{
    "nombre": Sequelize.STRING,
    "apellido": Sequelize.STRING
})
/*
const nombresModel2 = sequelize.define('empleados',{
    "nombre": Sequelize.STRING,
    "apellido": Sequelize.STRING
})*/

sequelize.authenticate()
    .then(()=>{
        console.log('CONEXIÓN A LA BASE DE DATOS OK')
    })
    .catch( error =>{
        console.log('EL ERROR DE CONEXION ES: '+ error)
    })


//Sincroniza el modelo con la base de datos
async function insertMillionData() {
    try {
      await sequelize.sync(); // Esto sincroniza el modelo con la base de datos, creando la tabla si no existe
  
      const totalRecords = 1000000; // 1 millón de registros
      const batchSize = 1000; // Tamaño del lote
  
      for (let i = 0; i < totalRecords; i += batchSize) {
        const dataToInsert = [];
  
        for (let j = 0; j < batchSize; j++) {
          const nombreAleatorio = faker.name.firstName();
          const apellidoAleatorio = faker.name.lastName();
  
          dataToInsert.push({
            nombre: nombreAleatorio,
            apellido: apellidoAleatorio
          });
        }
  
        await sequelize.transaction(async (t) => {
          await nombresModel.bulkCreate(dataToInsert, { transaction: t });
        });
  
        console.log(`Lote ${i / batchSize + 1} insertado.`);
      }
  
      console.log('Datos aleatorios insertados en la tabla');
    } catch (error) {
      console.error('Error al insertar datos:', error);
    }
  }


insertMillionData();
        
app.listen(3000, ()=>{
    console.log('Server up en http://localhost:3000')
})