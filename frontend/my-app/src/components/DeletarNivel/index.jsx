import { useNavigate, useParams } from "react-router-dom";
import Swal from "sweetalert2";
import { api } from "../../utils/api";

export function DeletarNivel() {
    const { id } = useParams();
    const navigate = useNavigate();

    Swal.fire({
        title: 'Deletar nivel?',
        text: "Esta ação deletara permanentemente o nivel",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            api.delete(`/niveis/${id}`)
                .then((response) => {
                    if (response.status === 204) {
                        Swal.fire(
                            'Deletado com sucesso!',
                            response.data.message,
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                navigate('/');
                            }
                            return
                        });
                    }
                })
                .catch((error) => {

                    if (error.response.status === 400) {
                        console.log(error.response.data.message)
                        Swal.fire({
                            icon: 'error',
                            title: 'Opa algo deu errado!',
                            text: error.response.data.message,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                navigate('/');
                                return
                            }
                        });
                        return
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Opa algo deu errado!',
                        text: error,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            navigate('/');
                        }
                    });
                })

        } else {
            navigate('/')
        }

    })
}