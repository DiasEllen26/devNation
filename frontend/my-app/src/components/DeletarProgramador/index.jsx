import { useNavigate, useParams } from "react-router-dom";
import Swal from "sweetalert2";
import { api } from "../../utils/api";

export function DeletarProgramador() {
    const { id } = useParams();
    const navigate = useNavigate();

    Swal.fire({
        title: 'Deletar programador?',
        text: "Esta ação deletara permanentemente o programador",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            api.delete(`/programadores/${id}`)
                .then((response) => {
                    Swal.fire(
                        'Deletado com sucesso!',
                        response.data.message,
                        'success'
                    ).then((result) => {
                        if (result.isConfirmed) {
                            navigate('/');
                        }
                    });
                })
                .catch((response) => {
                    const errorResponse = response.response.data;
                    const errors = Object.values(errorResponse.error);
                    const errorMenssage = errors.reduce((mensageFinal, error) => {
                        return mensageFinal + error
                    }, "");

                    Swal.fire({
                        icon: 'error',
                        title: 'Opa algo deu errado!',
                        text: errorMenssage,
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