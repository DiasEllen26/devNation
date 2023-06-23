
import './style.css'


export function Modal({ visible, children, title, onClose }) {

    if (!visible)
        return null

    return (
        <>

            <div className="containerModal">
                <div className="modalContentStyle">
                    <div className="modalIconClose">
                        <button onClick={onClose}><i class="bi bi-x-circle" style={{ fontSize: '25px' }}></i></button>
                    </div>
                    <div className="hearderModal">
                        <h2 className='text-center'>{title}</h2>
                    </div>
                    <div className="bodyModal">
                        {children}
                    </div>
                </div>
            </div>


        </>
    )
}