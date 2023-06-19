# SOL_ITCG
El sistema busca centralizar las solicitudes de mantenimiento, mejorando la rapidez y eficacia dentro de la institución debido a la falta constante de comunicación con respecto a al proceso de seguimiento de las diversas solicitudes generadas. Esta aplicación integra el Framework de Kanban como modelo de trabajo, en conjunto con los estándares de los departamentos asociados, lo que da como resultado un sistema donde existen cinco tipos de roles de usuarios.
1.	SuperAdministrador; puede crear, consultar, modificar, cambiar el estado y restablecer la contraseña de los usuarios. Además de poder decidir si la solicitud es aceptada o rechazada, finalizarla o cancelarla, consultar el tablero Kanban, ver los reportes y estadísticas, exportar los datos, manejar los parámetros de las solicitudes o imprimir las solicitudes finalizadas.
2.	Administrador; puede consultar los usuarios. Además de poder decidir si la solicitud es aceptada o rechazada, finalizarla o cancelarla, consultar el tablero Kanban, ver los reportes y estadísticas, exportar los datos, manejar los parámetros de las solicitudes o imprimir las solicitudes finalizadas.
3.	Solicitante; puede crear una nueva solicitud de ambos departamentos Centro de Cómputo y Mantenimiento de Equipo, ver el estado o etapa en el que se encuentra, modificar la solicitud cuando sea rechazada, cancelar en una etapa pendiente, confirmar el servicio o ver los detalles de su solicitud cuando finaliza o se cancela.
4.	Consultor; puede consultar de los usuarios. No es posible interactuar con los parámetros de la solicitud puede consultar el tablero Kanban y sus solicitudes, ver los reportes y estadísticas, exportar los datos o imprimir las solicitudes finalizadas.
5.	Trabajador; es única y exclusivamente para personal de Centro De Cómputo, debe de atender la orden de trabajo a las solicitudes que el departamento le haya asignado.

## Diagrama E-R

------------
![](https://lh3.googleusercontent.com/pw/AJFCJaXrjq1sd8F1VVYtXHKqU2zE5Q-gFrljEx-9WkGqXcvXFN_3j7kdDebYYt-TjXIA3GHPs3fOb-ifif_AaoaQ01Op56rhplRB97SAuPUIxkWEl26ep_t9VfujFfryqeQH-jXNtZtl1SuwZray1v1MhQHHectWpKrU05xBNiP_XLSH-3NdQjMjeEqGo5nfY4_DEqI4wLwut3ifmtDdg66OXntVJ6QIjO0Qb5Aq6BY3yqqOfoM5Cq6SAqksVIhpxun7HlM3ceQyvBxBpl-0HEV71icb1SguycS2TNJqzqXyiPj4eiscnCZtGobP15ONMfk5pKOlstOJwMzJQtb5n68HXaumrjRS9NodkuX5a-zutirbQQ9feStQPFcoHHBzG1BO5wDDu_iT0wLC4mWN9pOkA3OZ9QJfELnOz7Qqmlvxxj5IotIY6UOjNx4doTS8JvQzaqGQSNm9mYs_8_D5YY3t0kdtpuWaSWo9JeRuSQQ-N02-7exA1WiysgD0HcdbYm3FaePQZD29MUjDzClHymNAi2WKoKTRTHLl3d09kRzhw_mOVf0lm6ofoaOY_f8fAF0FkmqophIp0EE6CHqQhbk3LBLoeA2IA9lFKnGmOJR-oGuywTmmINFclniUMtzgn8RX5JonluO5VAcdBzFDdhAY6egEnvxGDbKDHp9fLg8f86Kg9Y2QaC5uW4-Su9h9yw4w9xNEvB9h4XftVPsSUogH_HjBTn1BEkNaZYTkoL_eSki9kaWtadHc2opg1TnW1D2hPuTU0BH2T6zhzY1yBfX3qnrBjXCGRsWSN4EIwTgQ23e_gjaLAeeyLWY2G-ehQyrhi0dA2pMH7NLIie3UEZLGhv35-8JNG02CJxDl_iQshg3EE3OWVybXxQp1dAqTHth07yIOzZKrtNF7l_Fu4niSMxbYz4h4EXTfHRhap_KEFNkjYgOqVIZ18nEV4y-FAYXSMvtG2KqDJoLbk5dfFiwdTHM6yq0faNCQjzxGQ00fAUmjoT8=w1099-h937-s-no?authuser=0)

## Diagrama de casos de uso

------------

![](https://lh3.googleusercontent.com/pw/AJFCJaUMZEufRNAQ0XeoB273Jew4EkRjo2_efeKZrVDg-J36kc3500waZKz4O5JBNAAGcI_51TXwvKSayp-cSjXFva5nzgCJ_F7EVwScj_GcDW5J5zsiYtk1vM8bK5glhbBu-Yd0u_KU2MY9UnmSKhwsBuXjkn1-q_AAJZ7hy7mpzB1wZvE3URVlB2_22KtNqAC9_sPOTRSzcKx65rb8qlLcBAr2lIDjtiPzW6I6i1LPCZVRHsl9sqFKSgj_-tE2t78yVcQC4Ki-kpTwTXXDpZyBtq-FKNVg1gRRddVheAs5unYBXD02CXNK89eE0yoNBznjRtWJdcR7Jq-WlUR-JDGa1kyUkD69yLruDLaf_w32W_Z07KaWh2Vc7Catk1J9VgS7Q_iN6K6ATa_2LiStIGvv5Th4TcmRxVzf-tDBm3JhWhSYQUHyFdurbt30sa6gC_SBxgHEOX3HSaLtDNXpEfRtn6LtlMv_SaCJESTF4AF2dxN3FbnzRuRlzIX2UfJ7IO5us9uSzSI-7Qzb0VU66RpdmCmGf3GdWNACTACmxd5aVojFdXCz4S_zXqm8B3-e_DOG6FhQTBWl9TP1jvxH2daylaR2_1SrbGynm4hSVEDFNKoFVCNzzExB2P3TKoS67nHezMIlHC4sl4mMzk7ot3dqSXZulkSQA6yDR2iFIbl6iv0aZeFCHbIpvVYIywmg_YQ9cFAcvQdIfMyPsnQrh61KhyEWv2OVtGj0D7KTMeMQChGXJmtSAwSUcpGSWqjvHoFfIYLeerZ-4WZYNqePX1BxpIiJ9Z8fihCkF6GsEU_1OXthGYBJ0BLfWInIIQhnAxvxupDDbYG7_zI7ts2yPfJCETBohK0RTDO287GEYxGvcIPDnwgeROrMP1ZJSpS4KfiZfprE_wmYJlBPwPz256Y6TIpxi4561IvH_Ocm90afpJj6MwnU7OgpDCiagCSuH4yQhVUiqRV6fuKdMTvHwG64JCy5q_HwkChZHQeKyEanC3AdEYQ=w755-h937-s-no?authuser=0)

Contribución
------------
1. Crea un Fork del repositorio
2. Clonar en tu maquina mediante git clone 
3. Crear una nueva rama
4. Realiza tus cambios
5. Manda tu pull request
