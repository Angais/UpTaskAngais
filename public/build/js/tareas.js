!function(){!async function(){try{const t="/api/tareas?id="+d(),a=await fetch(t),n=await a.json();e=n.tareas,o()}catch(e){console.log(e)}}();let e=[],t=[];function a(a){const n=a.target.value;t=""!==n?e.filter(e=>e.estado===n):[],o()}document.querySelector("#agregar-tarea").addEventListener("click",(function(){n()}));function o(){!function(){const e=document.querySelector("#listado-tareas");for(;e.firstChild;)e.removeChild(e.firstChild)}(),function(){const t=e.filter(e=>"0"===e.estado),a=document.querySelector("#pendientes");0===t.length?a.disabled=!0:a.disabled=!1}(),function(){const t=e.filter(e=>"1"===e.estado),a=document.querySelector("#completadas");0===t.length?a.disabled=!0:a.disabled=!1}();const a=t.length?t:e;if(0===a.length){const e=document.querySelector("#listado-tareas"),t=document.createElement("LI");return t.textContent="No hay Tareas",t.classList.add("no-tareas"),void e.appendChild(t)}const r={0:"Pendiente",1:"Completa"};a.forEach(t=>{const a=document.createElement("LI");a.dataset.tareaId=t.id,a.classList.add("tarea");const i=document.createElement("P");i.textContent=t.nombre,i.onclick=function(){n(editar=!0,{...t})};const s=document.createElement("DIV");s.classList.add("opciones");const l=document.createElement("BUTTON");l.classList.add("estado-tarea"),l.classList.add(""+r[t.estado].toLowerCase()),l.textContent=r[t.estado],l.dataset.estadoTarea=t.estado,l.onclick=function(){!function(e){const t="1"===e.estado?"0":"1";e.estado=t,c(e)}({...t})};const m=document.createElement("BUTTON");m.classList.add("eliminar-tarea"),m.dataset.idTarea=t.id,m.textContent="Eliminar",m.onclick=function(){!function(t){Swal.fire({title:"¿Eliminar Tarea?",showCancelButton:!0,confirmButtonText:"Sí",cancelButtonText:"Cancelar"}).then(a=>{a.isConfirmed&&a.isConfirmed&&async function(t){const{estado:a,id:n,nombre:r}=t,c=new FormData;c.append("id",n),c.append("nombre",r),c.append("estado",a),c.append("proyectoId",d());try{const a=location.origin+"/api/tarea/eliminar",n=await fetch(a,{method:"POST",body:c});console.log(n);const r=await n.json();r.resultado&&(Swal.fire("¡Eliminada!",r.mensaje,"success"),e=e.filter(e=>e.id!==t.id),o())}catch(e){}}(t)})}({...t})},s.appendChild(l),s.appendChild(m),a.appendChild(i),a.appendChild(s);document.querySelector("#listado-tareas").appendChild(a)})}function n(t=!1,a={}){const n=document.createElement("DIV");n.classList.add("modal"),n.innerHTML=`\n            <form class="formulario nueva-tarea">\n                <legend>${t?"Editar Tarea":"Añade una Tarea"}</legend>\n                <div class="campo">\n                    <label>Tarea</label>\n                    <input\n                        type="text"\n                        name="tarea"\n                        placeholder="${a.nombre?"Nuevo Nombre":"Añadir Tarea al Proyecto"}"\n                        id="tarea"\n                        value="${a.nombre?a.nombre:""}"\n                    />\n                </div>\n                <div class="opciones">\n                    <input \n                        type="submit" \n                        class="submit-nueva-tarea" \n                        value="${a.nombre?"Guardar Cambios":"Añadir Tarea"}"\n                        />\n                    <button type="button" class="cerrar-modal">Cancelar</button>\n                </div>\n            </form>\n        `,document.body.classList.add("modal-open"),setTimeout(()=>{document.querySelector(".formulario").classList.add("animar")},0),n.addEventListener("click",(function(i){if(i.preventDefault(),i.target.classList.contains("cerrar-modal")){document.querySelector(".formulario").classList.add("cerrar"),setTimeout(()=>{n.remove(),document.body.classList.remove("modal-open")},600)}if(i.target.classList.contains("submit-nueva-tarea")){const n=document.querySelector("#tarea").value.trim();if(""===n)return void r("Añada un nombre a la Tarea","error",document.querySelector(".formulario legend"));t?(a.nombre=n,c(a)):async function(t){const a=new FormData;a.append("nombre",t),a.append("proyectoId",d());try{const n=location.origin+"/api/tarea",c=await fetch(n,{method:"POST",body:a}),d=await c.json();if(console.log(d),r(d.mensaje,d.tipo,document.querySelector(".formulario legend")),"exito"===d.tipo){const a=document.querySelector(".modal");document.querySelector(".formulario").classList.add("cerrar"),setTimeout(()=>{a.remove(),document.body.classList.remove("modal-open")},400);const n={id:String(d.id),nombre:t,estado:"0",proyectoId:d.proyectoId};e=[...e,n],o()}}catch(e){r("Error Fatal de Conexión","error",document.querySelector(".formulario legend"))}}(n)}})),window.addEventListener("click",(function(e){if(e.target===n){document.querySelector(".formulario").classList.add("cerrar"),setTimeout(()=>{n.remove(),document.body.classList.remove("modal-open")},600)}})),document.querySelector(".dashboard").appendChild(n)}function r(e,t,a){const o=document.querySelector(".alerta");o&&o.remove();const n=document.createElement("DIV");n.classList.add("alerta",t),n.textContent=e,a.parentElement.insertBefore(n,a.nextElementSibling),setTimeout(()=>{n.remove()},3e3)}async function c(t){const{estado:a,id:n,nombre:r,proyectoId:c}=t,i=new FormData;i.append("id",n),i.append("nombre",r),i.append("estado",a),i.append("proyectoId",d());try{const t=location.origin+"/api/tarea/actualizar",c=await fetch(t,{method:"POST",body:i});if("exito"===(await c.json()).respuesta.tipo){const t=document.querySelector(".modal");if(t){document.querySelector(".formulario").classList.add("cerrar"),setTimeout(()=>{t.remove(),document.body.classList.remove("modal-open")},600)}e=e.map(e=>(e.id===n&&(e.estado=a,e.nombre=r),e)),o()}}catch(e){}}function d(){const e=new URLSearchParams(window.location.search);return Object.fromEntries(e.entries()).id}document.querySelectorAll('#filtros input[type="radio"]').forEach(e=>{e.addEventListener("input",a)})}();